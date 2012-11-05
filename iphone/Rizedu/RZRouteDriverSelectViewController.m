//
//  RZDriverSelectionViewController.m
//  RouteFlow
//
//  Created by Tao Xie on 9/27/12.
//  Copyright (c) 2012 Ridezu Inc. All rights reserved.
//

#import "RZRouteDriverSelectViewController.h"
#import "DriverTableViewCell.h"
#import "RZRouteSuccessViewController.h"
#import "RZRideDriver.h"
#import "RZRideDetail.h"

@interface RZRouteDriverSelectViewController () <UITableViewDelegate, UITableViewDataSource, UIPickerViewDelegate>{
    
}
@property (nonatomic, strong) IBOutlet UITableView *driversTableView;
@property (nonatomic, strong) NSArray *drivers;
@property (nonatomic, strong) RZRideDetail *rideDetail;
@end

@implementation RZRouteDriverSelectViewController

- (id)initWithAvailableDrivers:(NSArray *)drivers andRideDetail:(RZRideDetail *)rideDetail {
    if ((self = [[RZRouteDriverSelectViewController alloc] initWithNibName:@"RZRouteDriverSelectViewController" bundle:nil])) {
        self.title = @"Select Driver";
        _drivers = drivers;
        _rideDetail = rideDetail;
        return self;
    }
    return nil;
}

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
    
    NSArray* topObjects = [[NSBundle mainBundle] loadNibNamed:@"TopView" owner:self options:nil];
   
    TopView *topView = (TopView*)[topObjects objectAtIndex:0];
    [topView customize];
    CGRect topViewFrame = CGRectMake(10, 10, topView.bounds.size.width, topView.bounds.size.height);
    topView.frame = topViewFrame;
    [self.view addSubview:topView];
    
    _driversTableView.delegate = self;
    _driversTableView.dataSource = self;
    
     // customize back buttonItem 
    UIImage *backButtonImage = [UIImage imageNamed:@"arrow_left.png"];
    UIBarButtonItem *customItem = [[UIBarButtonItem alloc] initWithImage:backButtonImage style:UIBarButtonItemStylePlain target:self.navigationController action:@selector(popViewControllerAnimated:)];
    [self.navigationItem setLeftBarButtonItem: customItem];
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
    return 76;
}
- (NSString *)tableView:(UITableView *)tableView titleForHeaderInSection:(NSInteger)section {
    return [NSString stringWithFormat:@"%d drivers leaving at 6:00am", [_drivers count]];
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
    return [_drivers count];
}

// Customize the appearance of table view cells.
- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    static NSString *CellIdentifier = @"drivertable-Cell";
    
    DriverTableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:CellIdentifier];
    
    if (cell == nil) {
        NSArray* topObjects = [[NSBundle mainBundle] loadNibNamed:@"DriverTableViewCell" owner:self options:nil];
        cell = [topObjects objectAtIndex:0];
        cell.accessoryType = UITableViewCellAccessoryDisclosureIndicator;
    }
    RZRideDriver *ride = [_drivers objectAtIndex:indexPath.row];
    
    [cell.imageView setImage:[UIImage imageNamed:@"user"]];
    cell.nameLabel.text = ride.fullName;
    return cell;
}

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{
    RZRideDriver *driver = [_drivers objectAtIndex:indexPath.row];
    RZRouteSuccessViewController *routeSuccessViewController = [[RZRouteSuccessViewController alloc] initWithDriver:driver andRideDetail:_rideDetail];
    [self.navigationController pushViewController:routeSuccessViewController animated:YES];
    [tableView deselectRowAtIndexPath:indexPath animated:YES];
}

- (BOOL)tableView:(UITableView *)tableView canEditRowAtIndexPath:(NSIndexPath *)indexPath
{
    return NO;
}

@end
