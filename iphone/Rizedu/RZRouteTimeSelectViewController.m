//
//  RZViewController.m
//  RouteFlow
//
//  Created by Tao Xie on 9/24/12.
//  Copyright (c) 2012 Tao Xie. All rights reserved.
//

#import "RZRouteTimeSelectViewController.h"
#import "RZRouteDriverSelectViewController.h"
#import "TimeTableViewCell.h"
#import <QuartzCore/QuartzCore.h>

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
    _times = @[@"6:30", @"7:00", @"7:30", @"8:00", @"Custom"];
    _lastSelected = [NSIndexPath indexPathForRow:1 inSection:0];
    _timeTableFrame = CGRectMake(_timeTable.frame.origin.x, _timeTable.frame.origin.y,
                                 _timeTable.frame.size.width, _timeTable.frame.size.height);
    
    UIBarButtonItem *rightButton = [[UIBarButtonItem alloc] initWithTitle:@"Next"
                                                                    style:UIBarButtonSystemItemDone target:self action:@selector(nextButtonPressed)];
    self.navigationItem.rightBarButtonItem = rightButton;
}

- (void)nextButtonPressed {
    RZRouteDriverSelectViewController *driverViewController = [[RZRouteDriverSelectViewController alloc] initWithAvailableDrivers:@[@"Don Alex", @"Jeff Smith", @"Nikko Alexander"]];
    [self.navigationController pushViewController:driverViewController animated:YES];

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
    
    TimeTableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:CellIdentifier];
    
    if (cell == nil) {
        NSArray* topObjects = [[NSBundle mainBundle] loadNibNamed:@"TimeTableViewCell" owner:self options:nil];
        cell = [topObjects objectAtIndex:0];
        if (_lastSelected && indexPath.row == _lastSelected.row) {
            cell.accessoryType = UITableViewCellAccessoryCheckmark;
        }
    }
    cell.timeLabel.text = [_times objectAtIndex:indexPath.row];
    // cell.textLabel.text = [_times objectAtIndex:indexPath.row];
    cell.detailTextLabel.text = [NSString stringWithFormat:@"%@ driver(s) available", [_availRoutes objectAtIndex:indexPath.row]];
    return cell;
}

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{
    int oldRow = _lastSelected.row;
    int newRow = indexPath.row;

    if (oldRow != newRow) {
        UITableViewCell *newCell = [tableView cellForRowAtIndexPath:indexPath];
        newCell.accessoryType = UITableViewCellAccessoryCheckmark;
    
        UITableViewCell *oldCell = [tableView cellForRowAtIndexPath:_lastSelected];
        oldCell.accessoryType = UITableViewCellAccessoryNone;
        
        // custom item
        if (indexPath.row == ([_times count] - 1)) {
            _datePicker = [[UIDatePicker alloc] initWithFrame:CGRectMake(0, self.view.frame.size.height-216, 0, 0)];
            NSLog(@"picker: (%f, %f, %f, %f)", _datePicker.frame.origin.x, _datePicker.frame.origin.y, _datePicker.frame.size.width, _datePicker.frame.size.height);
            NSLog(@"table: (%f, %f, %f, %f)", _timeTable.frame.origin.x, _timeTable.frame.origin.y, _timeTable.frame.size.width, _timeTable.frame.size.height);
            _datePicker.datePickerMode = UIDatePickerModeTime;
            _datePicker.hidden = NO;
            _datePicker.date = [NSDate date];
            _isPickerShown = YES;
            [_datePicker addTarget:self action:@selector(changeDateInLabel:) forControlEvents:UIControlEventValueChanged];
            _timeTable.frame = CGRectMake(0, -44, 320.0, 427.00);
            [self.view addSubview:_datePicker];
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
