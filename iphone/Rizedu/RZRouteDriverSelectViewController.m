//
//  RZDriverSelectionViewController.m
//  RouteFlow
//
//  Created by Tao Xie on 9/27/12.
//  Copyright (c) 2012 Ridezu Inc. All rights reserved.
//

#import "RZRouteDriverSelectViewController.h"
#import "DriverTableViewCell.h"
#import <QuartzCore/QuartzCore.h>
#import "RZRouteSucessViewController.h"

@interface RZRouteDriverSelectViewController () <UITableViewDelegate, UITableViewDataSource, UIPickerViewDelegate>{
    
}
@property (nonatomic, strong) IBOutlet UILabel *costSavingAmountLabel;
@property (nonatomic, strong) IBOutlet UILabel *gasCarbonSavingLabel;
@property (nonatomic, strong) IBOutlet UIView *routeContainerView;
@property (nonatomic, strong) IBOutlet UITableView *driversTableView;
@property (nonatomic, strong) NSArray *drivers;
@end

@implementation RZRouteDriverSelectViewController

- (id)initWithAvailableDrivers:(NSArray *)drivers {
    if ((self = [[RZRouteDriverSelectViewController alloc] initWithNibName:@"RZRouteDriverSelectViewController" bundle:nil])) {
        self.title = @"Request a Ride";
        _drivers = drivers;
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
    _routeContainerView.layer.masksToBounds = YES;
    _routeContainerView.layer.cornerRadius = 10.0;
    
    _gasCarbonSavingLabel.layer.masksToBounds = YES;
    _gasCarbonSavingLabel.layer.cornerRadius = 5.0;
    
    _costSavingAmountLabel.layer.masksToBounds = YES;
    _costSavingAmountLabel.layer.cornerRadius = 5.0;
    
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
    [cell.imageView setImage:[UIImage imageNamed:@"user"]];
    cell.nameLabel.text = [_drivers objectAtIndex:indexPath.row];
    return cell;
}

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{
    RZRouteSucessViewController *routeSuccessViewController = [[RZRouteSucessViewController alloc] initWithNibName:@"RZRouteSucessViewController" bundle:nil];
    [self.navigationController pushViewController:routeSuccessViewController animated:YES];
    [tableView deselectRowAtIndexPath:indexPath animated:YES];
}

- (BOOL)tableView:(UITableView *)tableView canEditRowAtIndexPath:(NSIndexPath *)indexPath
{
    return NO;
}

@end
