//
//  Copyright (c) 2012 Parse. All rights reserved.

#import "LoginViewController.h"
#import "RZUserProfileViewController.h"
#import "Parse/Parse.h"

@implementation LoginViewController

@synthesize activityIndicator;

#pragma mark - View lifecycle

- (void)viewDidLoad
{
    [super viewDidLoad];
    [self setTitle:@"Login with Facebook"];
    
    // Check if user is cached and linked to Facebook, if so, bypass login    
    if ([PFUser currentUser] && [PFFacebookUtils isLinkedWithUser:[PFUser currentUser]]) {
        RZUserProfileViewController *rzUserProfileViewController = [[RZUserProfileViewController alloc] initWithNibName:@"RZUserProfileViewController" bundle:nil];

        UIBarButtonItem *slideButtonItem = [RZGlobalService grabberBarButtonItem:self.navigationController];
        self.navigationItem.leftBarButtonItem = slideButtonItem;
        
        [self.navigationController pushViewController:rzUserProfileViewController animated:NO];
    }
    else {
        // not loged in
        NSLog(@"not FaceBook login");
    }
}

- (void)viewWillAppear:(BOOL)animated {
    [self enableSwipeToRevealGesture:YES];
}
#pragma mark - Login mehtods

/* Login to facebook method */
- (IBAction)loginButtonTouchHandler:(id)sender 
{
    // Set permissions required from the facebook user account
    NSArray *permissionsArray = [NSArray arrayWithObjects:@"user_about_me", @"email", @"user_relationships", @"user_birthday",@"user_location", @"user_work_history", @"offline_access", nil];
    
    // Login PFUser using facebook
    [PFFacebookUtils logInWithPermissions:permissionsArray block:^(PFUser *user, NSError *error) {
        [activityIndicator stopAnimating]; // Hide loading indicator
        
        if (!user) {
            if (!error) {
                NSLog(@"Uh oh. The user cancelled the Facebook login.");
            } else {
                NSLog(@"Uh oh. An error occurred: %@", error);
            }
        } else if (user.isNew) {
            NSLog(@"User with facebook signed up and logged in!");
            // [self.navigationController pushViewController:[[UserDetailsViewController alloc] initWithStyle:UITableViewStyleGrouped] animated:YES];
        } else {
            NSLog(@"User with facebook logged in!");
            RZUserProfileViewController *profileVC = [[RZUserProfileViewController alloc] initWithNibName:@"RZUserProfileViewController" bundle:nil];
            [self.navigationController pushViewController:profileVC animated:YES];
        }
    }];
    
    [activityIndicator startAnimating]; // Show loading indicator until login is finished
}

@end
