//
//  RZUserProfileViewController.m
//  Rizedu
//
//  Created by Tao Xie on 10/6/12.
//  Copyright (c) 2012 Tao Xie. All rights reserved.
//

#import "RZUserProfileViewController.h"
#import <MapKit/MapKit.h>
#import <Parse/Parse.h>
#import "MKNetworkKit.h"
#import "Utils.h"
#import "LoginViewController.h"
#import "RZLocationPickViewController.h"

@interface RZUserProfileViewController () <PF_FBRequestDelegate> {
    
}
@property (nonatomic, weak) IBOutlet UIImageView *avatarImageView;
@property (nonatomic, weak) IBOutlet UILabel *nameLabel;
@property (nonatomic, weak) IBOutlet UILabel *workplaceLabel;
@property (nonatomic, weak) IBOutlet UILabel *ageLabel;
@property (nonatomic, weak) IBOutlet UILabel *quotesLabel;
@property (nonatomic, weak) IBOutlet UITextView *bioTextView;
@property (nonatomic, weak) IBOutlet UIGlossyButton *nextButton;

@property (nonatomic, strong) IBOutlet MKMapView *homeMapView;
@property (nonatomic, strong) IBOutlet MKMapView *officeMapView;

@property (nonatomic, retain) NSString *fbId;
@property (nonatomic, strong) RZUser *rzUser;
@end

@implementation RZUserProfileViewController


- (void) nextButtonPressed:(id)sender {
    NSLog(@"nextButton Pressed");
    RZLocationPickViewController *locationPickViewController = [[RZLocationPickViewController alloc] initWithType:@"home" andUser:_rzUser];
    [self.navigationController pushViewController:locationPickViewController animated:YES];
}

//- (id)initWithFBId:(NSString *)fbId {
//    if (self = [super initWithNibName:@"RZUserProfileViewController" bundle:nil]) {
//        self.fbId = fbId;
//    }
//	return self;
//}

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        UIImage *slideImage = [UIImage imageNamed:@"menu.png"];
//        UIBarButtonItem *slideButtonItem = [[UIBarButtonItem alloc] initWithImage:slideImage style:UIBarButtonItemStylePlain target:self.navigationController action:@selector(popViewControllerAnimated:)];
        UIBarButtonItem *slideButtonItem = [[UIBarButtonItem alloc] initWithImage:slideImage style:UIBarButtonItemStylePlain target:self.navigationController action:nil];
        self.navigationItem.leftBarButtonItem = slideButtonItem;

    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    self.navigationItem.hidesBackButton = YES;
    [self setTitle:@"Profile"];
    [_nextButton setActionSheetButtonWithColor:[RZGlobalService lightGreenColor]];
    
    _rzUser = [[RZUser alloc] init];
    // Create request for user's facebook data
    NSString *requestPath = @"me/?fields=id,first_name,last_name,work,gender,birthday,relationship_status,bio,hometown,picture,quotes,email";
    
    // Send request to facebook
    [[PFFacebookUtils facebook] requestWithGraphPath:requestPath andDelegate:self];

    // Check if user is cached and linked to Facebook, if so, bypass login
    if ([PFUser currentUser] && [PFFacebookUtils isLinkedWithUser:[PFUser currentUser]]) {
        NSLog(@"here");
        [_nextButton addTarget:self action:@selector(nextButtonPressed:) forControlEvents:UIControlEventTouchUpInside];
    }
    else {
        LoginViewController *loginViewController = [[LoginViewController alloc] initWithNibName:@"LoginViewController" bundle:nil];
        [self.navigationController presentModalViewController:loginViewController animated:YES];
    }
}

- (void)viewWillAppear:(BOOL)animated {
    [self enableSwipeToRevealGesture:YES];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

#pragma mark - Facebook Request Delegate methods

/* Callback delegate method for a successful graph request */
-(void)request:(PF_FBRequest *)request didLoad:(id)result
{
    // Parse the data received
    NSDictionary *userData = (NSDictionary *)result;
    NSLog(@"userData: %@", userData);
    
    NSString *firstName = [userData objectForKey:@"first_name"];
    NSString *lastName = [userData objectForKey:@"last_name"];
    NSString *bio = [userData objectForKey:@"bio"];
    NSString *imageUrl = [[[userData objectForKey:@"picture"] objectForKey:@"data"] objectForKey:@"url"];
    NSString *employerName = [[[[userData objectForKey:@"work"] objectAtIndex:0] objectForKey:@"employer"] objectForKey:@"name"];
    NSString *birthDay = [userData objectForKey:@"birthday"];
    NSString *gender = [userData objectForKey:@"gender"];
    NSString *quotes = [userData objectForKey:@"quotes"];
    
    
    _nameLabel.text = [NSString stringWithFormat:@"%@ %@", firstName, lastName];
    _ageLabel.text = [NSString stringWithFormat:@"%@ %@", [Utils ageRange:birthDay], gender];
    _workplaceLabel.text = (employerName) ? employerName : @"";
    _bioTextView.text = bio;
    _quotesLabel.text = [NSString stringWithFormat:@"quote: \"%@\"", quotes];
    
    MKNetworkEngine* engine = [[MKNetworkEngine alloc] initWithHostName:@"facebook.com" customHeaderFields:nil];
    NSURL* url = [NSURL URLWithString:imageUrl];
    
    //download the image
    [engine imageAtURL:url
          onCompletion:^(UIImage *fetchedImage, NSURL *url, BOOL isInCache) {
              [self performSelectorOnMainThread:@selector(updateImage:) withObject:fetchedImage waitUntilDone:YES];
          }];
    
    _rzUser.firstName = firstName;
    _rzUser.lastName = lastName;
    _rzUser.fbId = [userData objectForKey:@"id"];
    _rzUser.email = [userData objectForKey:@"email"];
}

- (void)updateImage:(UIImage*) fetchedImage {
    [self.avatarImageView setImage:fetchedImage];
}
/* Callback delegate method for an unsuccessful graph request */
-(void)request:(PF_FBRequest *)request didFailWithError:(NSError *)error
{
    NSString *errorType = [[[[[[error userInfo] objectForKey:@"com.facebook.sdk:ParsedJSONResponseKey"] objectAtIndex:0] objectForKey:@"body"] objectForKey:@"error"] objectForKey:@"type"];
    
    if ([errorType isEqualToString:@"OAuthException"]) {
        NSLog(@"The facebook session was invalidated");
        [self logoutButtonTouchHandler:nil];
    }
    else {
        
    }
//    if ([[[[error userInfo] objectForKey:@"error"] objectForKey:@"type"] isEqualToString: @"OAuthException"]) {
//        NSLog(@"The facebook session was invalidated");
//        [self logoutButtonTouchHandler:nil];
//    } else {
//        // FB account cached, but user de-authorize app from web
//        NSLog(@"Some other error");
//    }
}

#pragma mark - Logout method

- (void)logoutButtonTouchHandler:(id)sender
{
    // Logout user, this automatically clears the cache
    [PFUser logOut];
    
    // Return to login view controller
    [self.navigationController popToRootViewControllerAnimated:YES];
}

@end
