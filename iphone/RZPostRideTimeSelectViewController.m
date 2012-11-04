//
//  RZPostRideTimeSelectViewController.m
//  Rizedu
//
//  Created by Tao Xie on 10/21/12.
//  Copyright (c) 2012 Tao Xie. All rights reserved.
//

#import "RZPostRideTimeSelectViewController.h"
#import "TimeTableViewCell.h"
#import "UIAlertView+Blocks.h"
#import "RZAppDelegate.h"

@interface RZPostRideTimeSelectViewController () <UITableViewDelegate, UITableViewDataSource> {
    
}
@property (nonatomic, weak) IBOutlet UITableView *timeTable;
@property (nonatomic, strong) NSArray *timeArray;
@property (nonatomic, strong) MKNetworkEngine *ridezuEngine;
@property (nonatomic, assign) BOOL toShowAllTime;
@end

@implementation RZPostRideTimeSelectViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
        self.title = @"Set Time";
        UIImage *slideImage = [UIImage imageNamed:@"menu.png"];
        UIBarButtonItem *slideButtonItem = [[UIBarButtonItem alloc] initWithImage:slideImage style:UIBarButtonItemStylePlain target:self.navigationController action:@selector(popViewControllerAnimated:)];
        self.navigationItem.leftBarButtonItem = slideButtonItem;
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    _timeTable.delegate = self;
    _timeTable.dataSource = self;
    _timeArray = [RZGlobalService shortTimeTable];
    _ridezuEngine = [[MKNetworkEngine alloc] initWithHostName:RIDEZU_HOSTNAME customHeaderFields:nil];
    _toShowAllTime = YES;
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

#pragma mark - Table View

- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView
{
    return 1;
}
- (CGFloat)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath {
    return 54;
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
    return [_timeArray count];
}

- (UIView *) tableView:(UITableView *)tableView viewForHeaderInSection:(NSInteger)section
{
    UIView *headerView = [[UIView alloc] initWithFrame:CGRectMake(0, 0, tableView.bounds.size.width, 40)];
    
    UILabel *label = [[UILabel alloc] initWithFrame:CGRectMake(14, 0, tableView.bounds.size.width - 10, 40)];
    label.lineBreakMode = UILineBreakModeWordWrap;
    label.numberOfLines = 0;
    label.text = @"What time do you want to go to work today?";
    label.font = [UIFont fontWithName:@"Helvetica-Bold" size:15];
    label.textColor = [UIColor colorWithRed:1.0 green:1.0 blue:1.0 alpha:0.75];
    label.backgroundColor = [UIColor clearColor];
    [headerView addSubview:label];
    
    return headerView;
}

// Customize the appearance of table view cells.
- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    static NSString *CellIdentifier = @"timetable-Cell";
    
    NSLog(@"--> (%d, %d)", indexPath.section, indexPath.row);
    TimeTableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:CellIdentifier];
    
    if (cell == nil) {
        NSArray* topObjects = [[NSBundle mainBundle] loadNibNamed:@"TimeTableViewCell" owner:self options:nil];
        cell = [topObjects objectAtIndex:0];
        cell.accessoryType = UITableViewCellAccessoryDisclosureIndicator;
    }
    
    if (indexPath.row == ([_timeArray count] - 1)) {
        if (_toShowAllTime) {
            cell.timeLabel.text = @"Show All";
        }
        else {
            cell.timeLabel.text = [_timeArray objectAtIndex:indexPath.row];
        }
    }
    else {
        cell.timeLabel.text = [_timeArray objectAtIndex:indexPath.row];
    }
    return cell;
}

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{    
    // press "Show all time"
    if (indexPath.row == ([_timeArray count] - 1)) {
        if (_toShowAllTime) {
            _timeArray = [RZGlobalService fullTimeTable];
            _toShowAllTime = NO;
        }
        else {
            _timeArray = [RZGlobalService shortTimeTable];
            _toShowAllTime = YES;
        }
        [_timeTable reloadData];
    }
    
    else {
        NSString* timeStr = [_timeArray objectAtIndex:indexPath.row];
        NSString* h2wDateTime = [RZGlobalService getDateTime:timeStr];
        NSString* fbId = [[NSUserDefaults standardUserDefaults] objectForKey:@"UserId"];
        NSDictionary *dict = @{@"fbid" : fbId, @"eventtime" : h2wDateTime, @"route" : @"h2w"};
        // {"fbid":"504711218","eventtime":"2012-10-22 9:30","route":"h2w"}
        [self post2Server:(NSMutableDictionary*)dict];
    }
    
    [tableView deselectRowAtIndexPath:indexPath animated:YES];
}

- (BOOL)tableView:(UITableView *)tableView canEditRowAtIndexPath:(NSIndexPath *)indexPath
{
    return NO;
}
- (NSString*)tableView:(UITableView *)tableView titleForHeaderInSection:(NSInteger)section {
    return @"What time do you want to go to work today?";
}

- (NSString *)tableView:(UITableView *)tableView titleForFooterInSection:(NSInteger)section {
    NSString *activeUserId = [[NSUserDefaults standardUserDefaults] objectForKey:@"UserId"];
    NSString *activeUserName = [[NSUserDefaults standardUserDefaults] objectForKey:@"UserName"];
    return [NSString stringWithFormat:@"Acting as %@ (%@)", activeUserId, activeUserName];
}

- (void)post2Server:(NSMutableDictionary*)params {
    MKNetworkOperation* op = [_ridezuEngine operationWithPath:@"ridezu/api/v/1/rides/driver" params:params httpMethod:@"POST" ssl:NO];
    [op setPostDataEncoding:MKNKPostDataEncodingTypeJSON];
    
    [op onCompletion:^(MKNetworkOperation *completedOperation) {
        NSDictionary *json = [op responseJSON];
        NSLog(@"postRide response: %@", json);
        NSString *origDesc = [json objectForKey:@"origindesc"];
        
        RIButtonItem *cancelItem = [RIButtonItem item];
        cancelItem.label = @"OK";
        cancelItem.action = ^{
            // Better redirect to somewhere else.
        };
        NSString *message = [NSString stringWithFormat:@"Sweet! Your ride is in %@ at %@. ",
                             [RZGlobalService getTime:[json objectForKey:@"eventtime"]], origDesc];
        UIAlertView *alertView = [[UIAlertView alloc] initWithTitle:@"Congratulations"
                                                            message:message
                                                   cancelButtonItem:cancelItem
                                                   otherButtonItems:nil, nil];
        [alertView show];
        // TODO txie want to go back to main (now temp login page)
        // RZAppDelegate* delegate = (RZAppDelegate*)[[UIApplication sharedApplication] delegate];
        // [self presentViewController:delegate.testUsersNav animated:YES completion:nil];
        [self.navigationController popToRootViewControllerAnimated:YES];
        
    }
     onError:^(NSError *error) {
         NSLog(@"%@", error);
     }];
    [_ridezuEngine enqueueOperation: op];
}


@end
