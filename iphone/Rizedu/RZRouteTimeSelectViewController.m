//
//  RZViewController.m
//  RouteFlow
//
//  Created by Tao Xie on 9/24/12.
//  Copyright (c) 2012 Ridezu Inc. All rights reserved.
//

#import "RZRouteTimeSelectViewController.h"
#import "RZRouteDriverSelectViewController.h"
#import "TimeTableViewCell.h"
#import <QuartzCore/QuartzCore.h>

#import "RZCustomTimeViewController.h"
#import "RZRideDriver.h"
#import "RZRideDetail.h"

@interface RZRouteTimeSelectViewController () <UITableViewDelegate, UITableViewDataSource, UIPickerViewDelegate> {
    
}
@property (nonatomic, strong) IBOutlet UITableView *timeTable;
@property (nonatomic, strong) IBOutlet UIDatePicker *datePicker;
@property (nonatomic, strong) NSArray *times;
@property (nonatomic, strong) NSArray *availRoutes;

@property (nonatomic, strong) NSIndexPath *lastSelected;
@property (nonatomic, assign) BOOL isPickerShown;
@property (nonatomic, assign) CGRect timeTableFrame;
@property (nonatomic) TimeTableViewCell *cellView;

@property (nonatomic, strong) IBOutlet UILabel *costSavingAmountLabel;
@property (nonatomic, strong) IBOutlet UILabel *gasCarbonSavingLabel;
@property (nonatomic, strong) IBOutlet UIView *routeContainerView;

@property (nonatomic, strong) NSMutableArray *driversArray;
@property (nonatomic, strong) RZRideDetail *rideDetail;
@end

@implementation RZRouteTimeSelectViewController

- (id)initWithAvailableRoutes:(NSArray *)routes {
    if ((self = [[RZRouteTimeSelectViewController alloc] initWithNibName:@"RZRouteTimeSelectViewController" bundle:nil])) {
        self.title = @"Request a Ride";
        _availRoutes = routes;
        return self;
    }
    return nil;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    
    _routeContainerView.layer.masksToBounds = YES;
    _routeContainerView.layer.cornerRadius = 10.0;

    _gasCarbonSavingLabel.layer.masksToBounds = YES;
    _gasCarbonSavingLabel.layer.cornerRadius = 5.0;
    
    _costSavingAmountLabel.layer.masksToBounds = YES;
    _costSavingAmountLabel.layer.cornerRadius = 5.0;
    
    _timeTable.delegate = self;
    _timeTable.dataSource = self;
    _times = @[@"7:00am", @"7:30am", @"8:00am", @"8:30am", @"Custom"];
    _lastSelected = [NSIndexPath indexPathForRow:1 inSection:0];
    _timeTableFrame = CGRectMake(_timeTable.frame.origin.x, _timeTable.frame.origin.y,
                                 _timeTable.frame.size.width, _timeTable.frame.size.height);
    
    UIBarButtonItem *rightButton = [[UIBarButtonItem alloc] initWithTitle:@"Next"
                                                                    style:UIBarButtonSystemItemDone target:self action:@selector(nextButtonPressed)];
    self.navigationItem.rightBarButtonItem = rightButton;
    
    _driversArray = [[NSMutableArray alloc] init];
}

- (void)getRidesById:(NSString*)fbId {
    // http://ec2-50-18-0-33.us-west-1.compute.amazonaws.com/ridezu/api/v/1/rides/search/fbid/500012114/driver
    NSString *path = [NSString stringWithFormat:@"ridezu/api/v/1/rides/search/fbid/%@/driver", fbId];
    MKNetworkOperation* op = [[RZGlobalService singleton].ridezuEngine operationWithPath:path params:nil httpMethod:@"GET" ssl:NO];
    
    [op onCompletion:^(MKNetworkOperation *completedOperation) {
        NSDictionary *json = [op responseJSON];
        NSLog(@"response: %@", json);
        _rideDetail = [[RZRideDetail alloc] initWithDict:json];
        NSDictionary *rides = [json objectForKey:@"rideList"];
        [rides enumerateKeysAndObjectsUsingBlock:^(id key, id obj, BOOL *stop) {
            NSLog(@"key = %@", key);
            NSMutableArray *ridesPerTimeslot = [[NSMutableArray alloc] init];
            for (NSDictionary *r in obj) {
                NSString *rideId = [r objectForKey:@"rideid"];
                NSLog(@"rideId = %@", rideId);
                
                if (rideId && rideId != nil && ![rideId isEqual:[NSNull null]]) {
                    RZRideDriver *rideInfo = [[RZRideDriver alloc] initWithDict:r];
                    [ridesPerTimeslot addObject:rideInfo];
                    NSLog(@"%@, %@", rideInfo.eventTime, rideInfo.fullName);
                    // [_driversArray addObject:@{key : rideInfo}];
                }
                else {
                    break;
                }
            }
            if ([ridesPerTimeslot count] > 0) {
                NSDictionary *timeslotDict = @{@"time" : key, @"rides" : ridesPerTimeslot};
                [_driversArray addObject:timeslotDict];
            }
            NSLog(@">>>>> %@", _driversArray);
        }];
//        NSPredicate *predicate = [NSPredicate predicateWithFormat:@"rideid.length > 0"];
//        NSArray* filtered = [rides filteredArrayUsingPredicate:predicate];
//        NSLog(@"filtered array: %@", filtered);
        NSLog(@"END with %@", _driversArray);
        [_timeTable reloadData];
    }
     onError:^(NSError *error) {
         NSLog(@"%@", error);
     }];
    [[RZGlobalService singleton].ridezuEngine enqueueOperation: op];
}

- (void)viewWillAppear:(BOOL)animated {
    NSString *activeUserId = [[NSUserDefaults standardUserDefaults] stringForKey:@"UserId"];
    NSString *activeUserName = [[NSUserDefaults standardUserDefaults] stringForKey:@"UserName"];
    NSLog(@"Acting as %@ (%@)", activeUserId, activeUserName);
    [self getRidesById:activeUserId];
    [_timeTable reloadData];
}

- (void)nextButtonPressed {
//    RZRouteDriverSelectViewController *driverViewController = [[RZRouteDriverSelectViewController alloc] initWithAvailableDrivers:@[@"Don Alex", @"Jeff Smith", @"Nikko Alexander"]];
//    [self.navigationController pushViewController:driverViewController animated:YES];

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
    return [_times count];
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
    
    if (_driversArray != nil && [_driversArray count] > 0 && [_driversArray count] > indexPath.row) {
        NSString *time = [[_driversArray objectAtIndex:indexPath.row] objectForKey:@"time"];
        NSArray *rides = [[_driversArray objectAtIndex:indexPath.row] objectForKey:@"rides"];
        cell.timeLabel.text = time;
        NSLog(@"label:%@, time:%@", cell.timeLabel.text, time);
        if ([cell.timeLabel.text isEqualToString:time]) {
            cell.detailLabel.text = [NSString stringWithFormat:@"%d drivers", [rides count]];
        }
    }
    else {
        cell.timeLabel.text = [_times objectAtIndex:indexPath.row];
    }
    return cell;
}

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{
    int driversCellNum = [_driversArray count];
    
    if (indexPath.row < driversCellNum) {
        // account page
        NSArray* rides = [[_driversArray objectAtIndex:indexPath.row] objectForKey:@"rides"];
        RZRouteDriverSelectViewController *driverViewController = [[RZRouteDriverSelectViewController alloc] initWithAvailableDrivers:rides andRideDetail:_rideDetail];
        [self.navigationController pushViewController:driverViewController animated:YES];

    }

    int oldRow = _lastSelected.row;
    int newRow = indexPath.row;

    if (oldRow != newRow) {
        UITableViewCell *newCell = [tableView cellForRowAtIndexPath:indexPath];
        newCell.accessoryType = UITableViewCellAccessoryCheckmark;
    
        UITableViewCell *oldCell = [tableView cellForRowAtIndexPath:_lastSelected];
        oldCell.accessoryType = UITableViewCellAccessoryNone;
        
        // custom item
        if (indexPath.row == ([_times count] - 1)) {
            RZCustomTimeViewController *vc = [[RZCustomTimeViewController alloc] initWithNibName:@"RZCustomTimeViewController" bundle:nil];
            [self presentViewController:vc animated:YES completion:nil];            
        }
        else {
            if (_isPickerShown) {
                _timeTable.frame = _timeTableFrame;
                _datePicker.frame = CGRectMake(0, -300, 0, 0);
                _isPickerShown = NO;
            }
            
        }

    }
    _lastSelected = indexPath;
    [tableView deselectRowAtIndexPath:indexPath animated:YES];
}

- (BOOL)tableView:(UITableView *)tableView canEditRowAtIndexPath:(NSIndexPath *)indexPath
{
    return NO;
}

- (NSString *)tableView:(UITableView *)tableView titleForFooterInSection:(NSInteger)section {
    NSString *activeUserId = [[NSUserDefaults standardUserDefaults] objectForKey:@"UserId"];
    NSString *activeUserName = [[NSUserDefaults standardUserDefaults] objectForKey:@"UserName"];
    return [NSString stringWithFormat:@"Acting as %@ (%@)", activeUserId, activeUserName];
}

# pragma mark UIPickerViewDelegate
- (void)changeDateInLabel:(id)sender{
	//Use NSDateFormatter to write out the date in a friendly format
    NSDateFormatter *dateFormat = [[NSDateFormatter alloc] init];
    [dateFormat setDateFormat:@"hh:mma"];
    NSString *dateString = [dateFormat stringFromDate:_datePicker.date];
    UITableViewCell *customCell = [_timeTable cellForRowAtIndexPath:_lastSelected];
    customCell.textLabel.text = [NSString stringWithFormat:@"%@", dateString];
}

@end
