//
//  RZMasterViewController.m
//  Rizedu
//
//  Created by Tao Xie on 9/22/12.
//  Copyright (c) 2012 Ridezu Inc. All rights reserved.
//

#import "RZTestUsersListViewController.h"

@interface RZTestUsersListViewController () {
    NSMutableArray *_objects;
    NSUInteger _activeRowNum;
}
- (void)pushViewController;
- (void)revealSidebar;
@end

@implementation RZTestUsersListViewController

- (id)initWithTitle:(NSString *)title withRevealBlock:(RevealBlock)revealBlock {
    if (self = [super initWithNibName:nil bundle:nil]) {
		self.title = title;
		_revealBlock = [revealBlock copy];
	}
	return self;
}

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        self.title = NSLocalizedString(@"Master", @"Master");
        _activeRowNum = 0;
    }
    return self;
}

#pragma mark Private Methods

- (void)revealSidebar {
	_revealBlock();
}

							
- (void)viewDidLoad
{
    [super viewDidLoad];

    UIImage *slideImage = [UIImage imageNamed:@"menu.png"];
    UIBarButtonItem *slideButtonItem = [[UIBarButtonItem alloc] initWithImage:slideImage style:UIBarButtonItemStylePlain target:self.navigationController action:@selector(popViewControllerAnimated:)];
    self.navigationItem.leftBarButtonItem = slideButtonItem;
    
    // init objects
    NSString *path = [[NSBundle mainBundle] pathForResource:@"TestUsers" ofType:@"plist"];    
    _objects = [[NSMutableArray alloc] initWithContentsOfFile:path];
    
    [self setPreference:[_objects objectAtIndex:0]];
}

- (void)viewWillAppear:(BOOL)animated {
    // enable pan gesture
    NSArray* gestureRecognizers = [self.navigationController.navigationBar gestureRecognizers];
    for (UIGestureRecognizer *gestureRecognizer in gestureRecognizers) {
        if ([gestureRecognizer isKindOfClass:[UIPanGestureRecognizer class]]) {
            gestureRecognizer.enabled = YES;
            // break;
        }
    }
    [super viewWillAppear:animated];
}

- (void)viewDidAppear:(BOOL)animated {
    // enable pan gesture
    NSArray* gestureRecognizers = [self.navigationController.navigationBar gestureRecognizers];
    for (UIGestureRecognizer *gestureRecognizer in gestureRecognizers) {
        if ([gestureRecognizer isKindOfClass:[UIPanGestureRecognizer class]]) {
            gestureRecognizer.enabled = YES;
            // break;
        }
    }
}

- (void)setPreference:(NSString*)des {
    NSArray *tokens = [des componentsSeparatedByString:@"|"];
    
    [[NSUserDefaults standardUserDefaults] setObject:[tokens objectAtIndex:0] forKey:@"UserId"];
    [[NSUserDefaults standardUserDefaults] setObject:[tokens objectAtIndex:1] forKey:@"UserName"];
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

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
    return _objects.count;
}

// Customize the appearance of table view cells.
- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    static NSString *CellIdentifier = @"TestUsersList-Cell";
    
    UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:CellIdentifier];
    if (cell == nil) {
        cell = [[UITableViewCell alloc] initWithStyle:UITableViewCellStyleValue2 reuseIdentifier:CellIdentifier];
        if (indexPath.row == _activeRowNum) {
            cell.accessoryType = UITableViewCellAccessoryCheckmark;
        }
    }
    NSArray *tokens = [_objects[indexPath.row] componentsSeparatedByString:@"|"];
    cell.textLabel.text = [tokens objectAtIndex:1];
    cell.detailTextLabel.text = [tokens objectAtIndex:0];
    return cell;
}

- (BOOL)tableView:(UITableView *)tableView canEditRowAtIndexPath:(NSIndexPath *)indexPath
{
    return NO;
}

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{
    int oldRow = _activeRowNum;
    
    if (oldRow != indexPath.row) {
        UITableViewCell *newCell = [tableView cellForRowAtIndexPath:indexPath];
        newCell.accessoryType = UITableViewCellAccessoryCheckmark;
        
        UITableViewCell *oldCell = [tableView cellForRowAtIndexPath:[NSIndexPath indexPathForRow:oldRow inSection:0]];
        oldCell.accessoryType = UITableViewCellAccessoryNone;
        _activeRowNum = indexPath.row;
        [self setPreference:[_objects objectAtIndex:_activeRowNum]];
    }
    [tableView deselectRowAtIndexPath:indexPath animated:YES];
}

@end
