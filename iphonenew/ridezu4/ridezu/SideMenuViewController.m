//
//  SideMenuViewController.m
//  MFSideMenuDemo
//
//  Created by Michael Frederick on 3/19/12.

#import "SideMenuViewController.h"
#import "MFSideMenu.h"
#import "WebViewController.h"

@implementation SideMenuViewController

@synthesize sideMenu;

- (void) viewDidLoad {
    [super viewDidLoad];
    CGRect searchBarFrame = CGRectMake(0, 0, self.tableView.frame.size.width, 45.0);
    UISearchBar *searchBar = [[UISearchBar alloc] initWithFrame:searchBarFrame];
    searchBar.delegate = self;
    self.tableView.backgroundColor = [UIColor colorWithRed:60.0/255.0f green:62.0/255.0f blue:63.0/255.0f alpha:1.0];
    self.tableView.separatorStyle = UITableViewCellSelectionStyleGray;
    
    array = [[NSMutableArray alloc] initWithObjects:@"Ridezu",@"My Rides",@"Request a Ride",@"Post a Ride",@"My Account",@"My Profile",@"How it Works",@"Ridezunomics",@"FAQ",@"Terms & Conditions", nil];
        
}

- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView
{
    return 1;
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
    return 10;
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    static NSString *CellIdentifier = @"Cell";
    
    UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:CellIdentifier];
    if (cell == nil) {
        cell = [[UITableViewCell alloc] initWithStyle:UITableViewStyleGrouped reuseIdentifier:CellIdentifier];
    }
    
    cell.textLabel.text = [array objectAtIndex:indexPath.row];
    cell.textLabel.textColor = [UIColor whiteColor];
    cell.textLabel.font = [UIFont systemFontOfSize:16.0f];
    cell.selectionStyle = UITableViewCellSelectionStyleGray;
    
    return cell;
}


#pragma mark - UITableViewDelegate

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath {
    
    NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
    [defaults setInteger:indexPath.row forKey:@"sideMenuIndex"];
    [defaults synchronize];
        
    [WebViewController sharedManager].title = [NSString stringWithFormat:@"%@",[array objectAtIndex:indexPath.row]];
    
    [[WebViewController sharedManager] javaScriptFunctions:indexPath.row];
    NSArray *controllers = [NSArray arrayWithObject:[WebViewController sharedManager]];
    self.sideMenu.navigationController.viewControllers = controllers;
    [self.sideMenu setMenuState:MFSideMenuStateHidden];
}

#pragma mark - UISearchBarDelegate

- (BOOL)searchBarShouldEndEditing:(UISearchBar *)searchBar {
    return YES;
}

- (void)searchBarSearchButtonClicked:(UISearchBar *)searchBar {
    [searchBar resignFirstResponder];
}

@end
