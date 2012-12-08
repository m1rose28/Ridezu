//
//  RZAppDelegate.m
//  Rizedu
//
//  Created by Tao Xie on 9/22/12.
//  Copyright (c) 2012 Ridezu Inc. All rights reserved.
//

#import "RZAppDelegate.h"

#import "GHMenuCell.h"
#import "GHMenuViewController.h"
#import "GHRevealViewController.h"

#import "RZLocationPickViewController.h"
#import "RZUserProfileViewController.h"
#import "RZOthersViewController.h"

#import "LoginViewController.h"

#import <Parse/Parse.h>
#import <CoreData/CoreData.h>

#define RIDEZU_FACEBOOK_APP_ID @"443508415694320"

#pragma mark -
#pragma mark Private Interface
@interface RZAppDelegate () 
@end

@implementation RZAppDelegate
@synthesize window;
@synthesize revealController, menuController;

extern CFAbsoluteTime StartTime;


// custom url schema handler
- (BOOL)application:(UIApplication *)application openURL:(NSURL *)url sourceApplication:(NSString *)sourceApplication annotation:(id)annotation {
    if ([[url absoluteString] hasPrefix:@"fb"]) {
        return [PFFacebookUtils handleOpenURL:url];
    }
    else {
        NSLog(@"custom url handler %@, %@", url.scheme, url.host);
    }
    return NO;
}

- (BOOL)application:(UIApplication *)application didFinishLaunchingWithOptions:(NSDictionary *)launchOptions
{
    dispatch_async(dispatch_get_main_queue(), ^{
        DLog(@"Launched in %f sec", CFAbsoluteTimeGetCurrent() - StartTime);
    });
    
    [Parse setApplicationId:@"kVziVVZMyX1fYktgCUZ7QXJ5zPkpUpFYXs1BWyuh"
                  clientKey:@"R4wRIvvyaNNQFNSKJzUIzPThSCaDSRtpJ2DbtIAo"];
    
    [PFFacebookUtils initializeWithApplicationId:RIDEZU_FACEBOOK_APP_ID];
    [self customizeAppearance];
    
    UIColor *bgColor = [UIColor colorWithRed:(0x3d/255.0f) green:(0x3c/255.0f) blue:(0x3d/255.0f) alpha:1.0f];
	self.revealController = [[GHRevealViewController alloc] initWithNibName:nil bundle:nil];
	self.revealController.view.backgroundColor = bgColor;
	
	RevealBlock revealBlock = ^(){
		[self.revealController toggleSidebar:!self.revealController.sidebarShowing
									duration:kGHRevealSidebarDefaultAnimationDuration];
	};
	
	NSArray *headers = @[[NSNull null], [NSNull null]];
    
    UINavigationController *myRidesNav = [[UINavigationController alloc] initWithRootViewController:
                                         [[RZOthersViewController alloc] initWithPath:@"myridesp" andTitle:@"My Rides" withRevealBlock:revealBlock]];
    
    UINavigationController *requestRideNav = [[UINavigationController alloc] initWithRootViewController:
                                              [[RZOthersViewController alloc] initWithPath:@"riderequestp" andTitle:@"Request a Ride" withRevealBlock:revealBlock]];
    
    UINavigationController *postRideNav = [[UINavigationController alloc] initWithRootViewController:
                                           [[RZOthersViewController alloc] initWithPath:@"ridepostp" andTitle:@"Post a Ride" withRevealBlock:revealBlock]];
    
    UINavigationController *enrollmentNav = [[UINavigationController alloc] initWithRootViewController:
                                             [[LoginViewController alloc] initWithNibName:@"LoginViewController" bundle:nil]];
    
    UINavigationController *profileNav = [[UINavigationController alloc] initWithRootViewController:
                                             [[RZOthersViewController alloc] initWithPath:@"profilep" andTitle:@"My Profile" withRevealBlock:revealBlock]];
    
    UINavigationController *howitworksNav = [[UINavigationController alloc] initWithRootViewController:
                                             [[RZOthersViewController alloc] initWithPath:@"howitworksp" andTitle:@"How it Works" withRevealBlock:revealBlock]];

    UINavigationController *ridezunomicsNav = [[UINavigationController alloc] initWithRootViewController:
                                             [[RZOthersViewController alloc] initWithPath:@"calcp" andTitle:@"Ridezunomics" withRevealBlock:revealBlock]];
    
    UINavigationController *faqNav = [[UINavigationController alloc] initWithRootViewController:
                                             [[RZOthersViewController alloc] initWithPath:@"faqp" andTitle:@"FAQ" withRevealBlock:revealBlock]];
    
    UINavigationController *tosNav = [[UINavigationController alloc] initWithRootViewController:
                                             [[RZOthersViewController alloc] initWithPath:@"termsp" andTitle:@"Terms of Service" withRevealBlock:revealBlock]];
           
	NSArray *controllers = @[
        @[myRidesNav, requestRideNav, postRideNav, enrollmentNav, profileNav],
        @[howitworksNav, ridezunomicsNav, faqNav, tosNav]
	];
    
    NSArray *cellInfos = nil;
    @try {
        cellInfos = @[
        @[
            @{kSidebarCellImageKey: [UIImage imageNamed:@"user.png"],     kSidebarCellTextKey: NSLocalizedString(@"My Rides", @"")},
            @{kSidebarCellImageKey: [UIImage imageNamed:@"user.png"],     kSidebarCellTextKey: NSLocalizedString(@"Request a Ride", @"")},
            @{kSidebarCellImageKey: [UIImage imageNamed:@"user.png"],      kSidebarCellTextKey: NSLocalizedString(@"Post a Ride", @"")},
            @{kSidebarCellImageKey: [UIImage imageNamed:@"user.png"],     kSidebarCellTextKey: NSLocalizedString(@"Enrollment", @"")},
            @{kSidebarCellImageKey: [UIImage imageNamed:@"user.png"],  kSidebarCellTextKey: NSLocalizedString(@"My Profile", @"")},
        ],
        @[
            @{kSidebarCellImageKey: [UIImage imageNamed:@"user.png"],  kSidebarCellTextKey: NSLocalizedString(@"How it works", @"")},
            @{kSidebarCellImageKey: [UIImage imageNamed:@"user.png"], kSidebarCellTextKey: NSLocalizedString(@"Ridezenomics", @"")},
            @{kSidebarCellImageKey: [UIImage imageNamed:@"user.png"],         kSidebarCellTextKey: NSLocalizedString(@"FAQ", @"")},
            @{kSidebarCellImageKey: [UIImage imageNamed:@"user.png"],       kSidebarCellTextKey: NSLocalizedString(@"Terms of Service", @"")},
        ]
    ];
    } @catch (NSException *ex) {
        NSLog(@"Exception creating cellinfo, probably bad gif name!");
        NSLog(@"%@",ex);
        @throw(ex);
    }


	// Add drag feature to each root navigation controller
	[controllers enumerateObjectsUsingBlock:^(id obj, NSUInteger idx, BOOL *stop){
		[((NSArray *)obj) enumerateObjectsUsingBlock:^(id obj2, NSUInteger idx2, BOOL *stop2){
			UIPanGestureRecognizer *panGesture = [[UIPanGestureRecognizer alloc] initWithTarget:self.revealController
																						 action:@selector(dragContentView:)];
			panGesture.cancelsTouchesInView = YES;
            if ([obj2 isKindOfClass:[UINavigationController class]]) {
                [((UINavigationController *)obj2).navigationBar addGestureRecognizer:panGesture];
            }
		}];
	}];

    UILabel *labelView = [[UILabel alloc] initWithFrame:CGRectMake(50, 10, 320, 44)];
    labelView.font = [UIFont fontWithName:@"Courier-Bold" size:24];
    labelView.backgroundColor = [UIColor clearColor];
    labelView.textColor = [UIColor whiteColor];
    labelView.text = @"Ridezu";
    
	self.menuController = [[GHMenuViewController alloc] initWithSidebarViewController:self.revealController
																		withSearchBar:labelView
																		  withHeaders:headers
																	  withControllers:controllers
																		withCellInfos:cellInfos];
    
    [application registerForRemoteNotificationTypes:UIRemoteNotificationTypeBadge|
     UIRemoteNotificationTypeAlert|
     UIRemoteNotificationTypeSound];
    
    self.window = [[UIWindow alloc] initWithFrame:[UIScreen mainScreen].bounds];
    self.window.rootViewController = self.revealController;
    [self.window makeKeyAndVisible];
    return YES;

}

- (void)application:(UIApplication *)application didRegisterForRemoteNotificationsWithDeviceToken:(NSData *)newDeviceToken {
    // Tell Parse about the device token.
    [PFPush storeDeviceToken:newDeviceToken];
    // Subscribe to the global broadcast channel.
    [PFPush subscribeToChannelInBackground:@"ridezu-pub"];
}

- (void)application:(UIApplication *)application didReceiveRemoteNotification:(NSDictionary *)userInfo {
    [PFPush handlePush:userInfo];
}

- (void)customizeAppearance {
    // this is to unset the background image by other themes
    [[UINavigationBar appearance] setBackgroundImage:[UIImage imageNamed:@"titlebar.png"] forBarMetrics:UIBarMetricsDefault];
    [[UIToolbar appearance] setBackgroundImage:nil forToolbarPosition:UIToolbarPositionAny barMetrics:UIBarMetricsDefault];
    [[UIToolbar appearance] setTintColor:[RZGlobalService greenColor]];
    [[UIBarButtonItem appearanceWhenContainedIn:[UINavigationBar class], nil] setTintColor:[RZGlobalService greenColor]];
    [[UISegmentedControl appearance] setTintColor:[RZGlobalService greenColor]];
}

- (void)applicationWillResignActive:(UIApplication *)application
{
    // Sent when the application is about to move from active to inactive state. This can occur for certain types of temporary interruptions (such as an incoming phone call or SMS message) or when the user quits the application and it begins the transition to the background state.
    // Use this method to pause ongoing tasks, disable timers, and throttle down OpenGL ES frame rates. Games should use this method to pause the game.
}

- (void)applicationDidEnterBackground:(UIApplication *)application
{
    // Use this method to release shared resources, save user data, invalidate timers, and store enough application state information to restore your application to its current state in case it is terminated later. 
    // If your application supports background execution, this method is called instead of applicationWillTerminate: when the user quits.
}

- (void)applicationWillEnterForeground:(UIApplication *)application
{
    // Called as part of the transition from the background to the inactive state; here you can undo many of the changes made on entering the background.
}

- (void)applicationDidBecomeActive:(UIApplication *)application
{
    // Restart any tasks that were paused (or not yet started) while the application was inactive. If the application was previously in the background, optionally refresh the user interface.
}

- (void)applicationWillTerminate:(UIApplication *)application {
    [self saveContext];
}

- (void)saveContext
{
    NSError *error = nil;
//    NSManagedObjectContext *managedObjectContext = self.managedObjectContext;
//    if (managedObjectContext != nil) {
//        if ([managedObjectContext hasChanges] && ![managedObjectContext save:&error]) {
//            NSLog(@"Unresolved error %@, %@", error, [error userInfo]);
//            abort();
//        }
//    }
}

#pragma mark - Application's Documents directory

// Returns the URL to the application's Documents directory.
- (NSURL *)applicationDocumentsDirectory
{
    return [[[NSFileManager defaultManager] URLsForDirectory:NSDocumentDirectory inDomains:NSUserDomainMask] lastObject];
}

- (void) applicationDidFinishLaunchingWithOption:(NSNotification*) notice {
    NSLog(@"inside appdidfinishlaunchingWithOptions") ;
}

@end
