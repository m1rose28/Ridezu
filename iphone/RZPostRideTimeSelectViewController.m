//
//  RZPostRideTimeSelectViewController.m
//  Rizedu
//
//  Created by Tao Xie on 10/21/12.
//  Copyright (c) 2012 Tao Xie. All rights reserved.
//

#import "RZPostRideTimeSelectViewController.h"
#import "TimeTableViewCell.h"

@interface RZPostRideTimeSelectViewController () <UITableViewDelegate, UITableViewDataSource> {
    
}
@property (nonatomic, weak) IBOutlet UITableView *timeTable;
@property (nonatomic, strong) NSIndexPath *lastSelected;
@property (nonatomic, strong) NSArray *timeArray;
@property (nonatomic, strong) MKNetworkEngine *ridezuEngine;
@end

@implementation RZPostRideTimeSelectViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    _timeTable.delegate = self;
    _timeTable.dataSource = self;
    _lastSelected = [NSIndexPath indexPathForRow:1 inSection:0];
    _timeArray = [RZGlobalService shortTimeTable];
    _ridezuEngine = [[MKNetworkEngine alloc] initWithHostName:@"ec2-50-18-0-33.us-west-1.compute.amazonaws.com" customHeaderFields:nil];
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

// Customize the appearance of table view cells.
- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    static NSString *CellIdentifier = @"timetable-Cell";
    
    NSLog(@"--> (%d, %d)", indexPath.section, indexPath.row);
    TimeTableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:CellIdentifier];
    
    if (cell == nil) {
        NSArray* topObjects = [[NSBundle mainBundle] loadNibNamed:@"TimeTableViewCell" owner:self options:nil];
        cell = [topObjects objectAtIndex:0];
        //        if (_lastSelected && indexPath.row == _lastSelected.row) {
        //            cell.accessoryType = UITableViewCellAccessoryCheckmark;
        //        }
    }
    // NSDictionary* timeslotDict = [_driversArray objectAtIndex:indexPath.row];
    // cell.timeLabel.text = [_times objectAtIndex:indexPath.row];
    
    if (indexPath.row == ([_timeArray count] - 1)) {
        cell.timeLabel.text = @"Show all time";
    }
    else {
        cell.timeLabel.text = [_timeArray objectAtIndex:indexPath.row];
    }
    return cell;
}

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{    
    // if (indexPath.row < driversCellNum) {
//        // account page
//        NSArray* rides = [[_driversArray objectAtIndex:indexPath.row] objectForKey:@"rides"];
//        RZRouteDriverSelectViewController *driverViewController = [[RZRouteDriverSelectViewController alloc] initWithAvailableDrivers:rides andRideDetail:_rideDetail];
        // [self.navigationController pushViewController:driverViewController animated:YES];
        
    // }
    
    int oldRow = _lastSelected.row;
    int newRow = indexPath.row;
    
    if (oldRow != newRow) {
        UITableViewCell *newCell = [tableView cellForRowAtIndexPath:indexPath];
        newCell.accessoryType = UITableViewCellAccessoryCheckmark;
        
        UITableViewCell *oldCell = [tableView cellForRowAtIndexPath:_lastSelected];
        oldCell.accessoryType = UITableViewCellAccessoryNone;
        
    }
    // {"fbid":"504711218","eventtime":"2012-10-22 9:30","route":"h2w"}
    // press "Show all time"
    if (indexPath.row == ([_timeArray count] - 1)) {
        _timeArray = [RZGlobalService fullTimeTable];
        [_timeTable reloadData];
    }
    
    _lastSelected = indexPath;
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
    MKNetworkOperation* op = [_ridezuEngine operationWithPath:@"ridezu/api/v/1/users/driver" params:params httpMethod:@"POST" ssl:NO];
    [op setPostDataEncoding:MKNKPostDataEncodingTypeJSON];
    
    [op onCompletion:^(MKNetworkOperation *completedOperation) {
        NSDictionary *json = [op responseJSON];
        NSLog(@"createUser response: %@", json);
    }
             onError:^(NSError *error) {
                 NSLog(@"%@", error);
             }];
    [_ridezuEngine enqueueOperation: op];
}


@end
