//
//  RZMasterViewController.m
//  Rizedu
//
//  Created by Tao Xie on 9/22/12.
//  Copyright (c) 2012 Ridezu Inc. All rights reserved.
//

#import "RZMasterViewController.h"

@interface RZMasterViewController () {
    NSMutableArray *_objects;
    NSUInteger _activeRowNum;
}
- (void)pushViewController;
- (void)revealSidebar;
@end

@implementation RZMasterViewController

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

    UIBarButtonItem *addButton = [[UIBarButtonItem alloc] initWithBarButtonSystemItem:UIBarButtonSystemItemAdd target:self action:@selector(insertNewObject:)];
    self.navigationItem.rightBarButtonItem = addButton;
    
    // init objects
    NSString *path = [[NSBundle mainBundle] pathForResource:@"TestUsers" ofType:@"plist"];    
    _objects = [[NSMutableArray alloc] initWithContentsOfFile:path];
    
    [self setPreference:[_objects objectAtIndex:0]];
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

- (void)insertNewObject:(id)sender
{
    if (!_objects) {
        _objects = [[NSMutableArray alloc] init];
    }
    [_objects insertObject:[NSDate date] atIndex:0];
    NSIndexPath *indexPath = [NSIndexPath indexPathForRow:0 inSection:0];
    [self.tableView insertRowsAtIndexPaths:@[indexPath] withRowAnimation:UITableViewRowAnimationAutomatic];
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
    static NSString *CellIdentifier = @"Cell";
    
    UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:CellIdentifier];
    if (cell == nil) {
        cell = [[UITableViewCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:CellIdentifier];
        if (indexPath.row == _activeRowNum) {
            cell.accessoryType = UITableViewCellAccessoryCheckmark;
        }
    }
    NSDate *object = _objects[indexPath.row];
    cell.textLabel.text = [object description];
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
