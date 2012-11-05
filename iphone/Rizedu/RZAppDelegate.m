//
//  RZAppDelegate.m
//  Rizedu
//
//  Created by Tao Xie on 9/22/12.
//  Copyright (c) 2012 Ridezu Inc. All rights reserved.
//

#import "RZAppDelegate.h"

#import "RZTestUsersListViewController.h"
#import "GHMenuCell.h"
#import "GHMenuViewController.h"
#import "GHRevealViewController.h"
#import "GHSidebarSearchViewController.h"
#import "GHSidebarSearchViewControllerDelegate.h"

#import "RZLocationPickViewController.h"
#import "RZFBLoginViewController.h"
#import "RZRouteTimeSelectViewController.h"
#import "RZUserProfileViewController.h"
#import "RZPostRideTimeSelectViewController.h"
#import "RZMyRidesViewController.h"
#import "RZOthersViewController.h"

#import "LoginViewController.h"

// #import <FacebookSDK/FacebookSDK.h>
#import <Parse/Parse.h>
#import <CoreData/CoreData.h>


#pragma mark -
#pragma mark Private Interface
@interface RZAppDelegate () <GHSidebarSearchViewControllerDelegate>
@property (nonatomic, strong) GHRevealViewController *revealController;
@property (nonatomic, strong) GHSidebarSearchViewController *searchController;
@property (nonatomic, strong) GHMenuViewController *menuController;
@end


@implementation RZAppDelegate
@synthesize window;
@synthesize revealController, searchController, menuController;

@synthesize managedObjectContext = _managedObjectContext;
@synthesize managedObjectModel = _managedObjectModel;
@synthesize persistentStoreCoordinator = _persistentStoreCoordinator;

extern CFAbsoluteTime StartTime;


// FBSample logic
// If we have a valid session at the time of openURL call, we handle Facebook transitions
// by passing the url argument to handleOpenURL; see the "Just Login" sample application for
// a more detailed discussion of handleOpenURL
- (BOOL)application:(UIApplication *)application openURL:(NSURL *)url sourceApplication:(NSString *)sourceApplication annotation:(id)annotation {
    // attempt to extract a token from the url
    // return [FBSession.activeSession handleOpenURL:url];
    return [PFFacebookUtils handleOpenURL:url];
}

- (BOOL)application:(UIApplication *)application didFinishLaunchingWithOptions:(NSDictionary *)launchOptions
{
    dispatch_async(dispatch_get_main_queue(), ^{
        DLog(@"Launched in %f sec", CFAbsoluteTimeGetCurrent() - StartTime);
    });
    
    [Parse setApplicationId:@"kVziVVZMyX1fYktgCUZ7QXJ5zPkpUpFYXs1BWyuh"
                  clientKey:@"R4wRIvvyaNNQFNSKJzUIzPThSCaDSRtpJ2DbtIAo"];
    
    [PFFacebookUtils initializeWithApplicationId:@"443508415694320"];
    [self customizeAppearance];
    
    UIColor *bgColor = [UIColor colorWithRed:(50.0f/255.0f) green:(57.0f/255.0f) blue:(74.0f/255.0f) alpha:1.0f];
	self.revealController = [[GHRevealViewController alloc] initWithNibName:nil bundle:nil];
	self.revealController.view.backgroundColor = bgColor;
	
	RevealBlock revealBlock = ^(){
		[self.revealController toggleSidebar:!self.revealController.sidebarShowing
									duration:kGHRevealSidebarDefaultAnimationDuration];
	};
	
	NSArray *headers = @[[NSNull null], @"FAVORITES"];
    
    
    _testUsersNav = [[UINavigationController alloc] initWithRootViewController:
                                            [[RZTestUsersListViewController alloc] initWithTitle:@"Login - Testing Only" withRevealBlock:revealBlock]];
    
    UINavigationController *myRidesNav = [[UINavigationController alloc] initWithRootViewController:
                                         [[RZMyRidesViewController alloc]
                                          initWithNibName:@"RZMyRidesViewController" bundle:nil]];
    
    UINavigationController *requestRideNav = [[UINavigationController alloc] initWithRootViewController:
                                              [[RZRouteTimeSelectViewController alloc] initWithAvailableRoutes:@[@"0", @"3", @"2", @"1", @""]]];
    
    UINavigationController *postRideNav = [[UINavigationController alloc] initWithRootViewController:
                                           [[RZPostRideTimeSelectViewController alloc] initWithNibName:@"RZPostRideTimeSelectViewController" bundle:nil]];
    
    UINavigationController *enrollmentNav = [[UINavigationController alloc] initWithRootViewController:
                                             [[LoginViewController alloc] initWithNibName:@"LoginViewController" bundle:nil]];
    
    UINavigationController *profileNav = [[UINavigationController alloc] initWithRootViewController:
                                          [[RZUserProfileViewController alloc] initWithNibName:@"RZUserProfileViewController" bundle:nil]];
    
    UINavigationController *howitworksNav = [[UINavigationController alloc] initWithRootViewController:
                                             [[RZTestUsersListViewController alloc] initWithTitle:@"How it works" withRevealBlock:revealBlock]];

    UINavigationController *othersNav = [[UINavigationController alloc] initWithRootViewController:
                                        [[RZOthersViewController alloc]
                                         initWithNibName:@"RZOthersViewController" bundle:nil]];
    
	NSArray *controllers = @[
        @[_testUsersNav],
        @[myRidesNav, requestRideNav, postRideNav, enrollmentNav, profileNav, othersNav, howitworksNav]
	];
    
	NSArray *cellInfos = @[
        @[@{kSidebarCellImageKey: [UIImage imageNamed:@"user.png"], kSidebarCellTextKey: NSLocalizedString(@"Login - Testing Only", @"")}
        ],
    @[
        @{kSidebarCellImageKey: [UIImage imageNamed:@"0019.png"], kSidebarCellTextKey: NSLocalizedString(@"My Rides", @"")},
        @{kSidebarCellImageKey: [UIImage imageNamed:@"0019.png"], kSidebarCellTextKey: NSLocalizedString(@"Request a Ride", @"")},
        @{kSidebarCellImageKey: [UIImage imageNamed:@"0100.png"], kSidebarCellTextKey: NSLocalizedString(@"Post a Ride", @"")},
        @{kSidebarCellImageKey: [UIImage imageNamed:@"0006.png"], kSidebarCellTextKey: NSLocalizedString(@"Enrollment", @"")},
        @{kSidebarCellImageKey: [UIImage imageNamed:@"user.png"], kSidebarCellTextKey: NSLocalizedString(@"My Profile", @"")},
        @{kSidebarCellImageKey: [UIImage imageNamed:@"user.png"], kSidebarCellTextKey: NSLocalizedString(@"Settings", @"")},
        @{kSidebarCellImageKey: [UIImage imageNamed:@"0208.png"], kSidebarCellTextKey: NSLocalizedString(@"How it works", @"")},
    ]
	];
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

    /*
    UIPanGestureRecognizer *panGesture = [[UIPanGestureRecognizer alloc] initWithTarget:self.revealController
                                                                                 action:@selector(dragContentView:)];
    panGesture.cancelsTouchesInView = YES;
    
    [testUsersNav.navigationBar addGestureRecognizer:panGesture];
    [requestRideNav.navigationBar addGestureRecognizer:panGesture];
    [postRideNav.navigationBar addGestureRecognizer:panGesture];
    [enrollmentNav.navigationBar addGestureRecognizer:panGesture];
    [profileNav.navigationBar addGestureRecognizer:panGesture];
    [howitworksNav.navigationBar addGestureRecognizer:panGesture];
   */
    
    
	self.searchController = [[GHSidebarSearchViewController alloc] initWithSidebarViewController:self.revealController];
	self.searchController.view.backgroundColor = [UIColor clearColor];
    self.searchController.searchDelegate = self;
	self.searchController.searchBar.autocapitalizationType = UITextAutocapitalizationTypeNone;
	self.searchController.searchBar.autocorrectionType = UITextAutocorrectionTypeNo;
	self.searchController.searchBar.backgroundImage = [UIImage imageNamed:@"searchBarBG.png"];
	self.searchController.searchBar.placeholder = NSLocalizedString(@"Search", @"");
	self.searchController.searchBar.tintColor = [UIColor colorWithRed:(58.0f/255.0f) green:(67.0f/255.0f) blue:(104.0f/255.0f) alpha:1.0f];
	for (UIView *subview in self.searchController.searchBar.subviews) {
		if ([subview isKindOfClass:[UITextField class]]) {
			UITextField *searchTextField = (UITextField *) subview;
			searchTextField.textColor = [UIColor colorWithRed:(154.0f/255.0f) green:(162.0f/255.0f) blue:(176.0f/255.0f) alpha:1.0f];
		}
	}
	[self.searchController.searchBar setSearchFieldBackgroundImage:[[UIImage imageNamed:@"searchTextBG.png"]
                                                                    resizableImageWithCapInsets:UIEdgeInsetsMake(16.0f, 17.0f, 16.0f, 17.0f)]
														  forState:UIControlStateNormal];
	[self.searchController.searchBar setImage:[UIImage imageNamed:@"searchBarIcon.png"]
							 forSearchBarIcon:UISearchBarIconSearch
										state:UIControlStateNormal];
	
	self.menuController = [[GHMenuViewController alloc] initWithSidebarViewController:self.revealController
																		withSearchBar:self.searchController.searchBar
																		  withHeaders:headers
																	  withControllers:controllers
																		withCellInfos:cellInfos];
	
    // [FBProfilePictureView class];

    // Just for Parse.com testing
//    PFObject *testObject = [PFObject objectWithClassName:@"TestObject"];
//    [testObject setObject:@"bar" forKey:@"foo"];
//    [testObject save];
    
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
    [[UINavigationBar appearance] setBackgroundImage:nil forBarMetrics:UIBarMetricsDefault];
    [[UIToolbar appearance] setBackgroundImage:nil forToolbarPosition:UIToolbarPositionAny barMetrics:UIBarMetricsDefault];
    
//    UIColor *navyBlue = [UIColor colorWithRed:0x00/255.f green:0x22/255.f blue:0x66/255.f alpha:1];
//    UIColor *bBlue = [UIColor colorWithRed:0x27/255.f green:0x40/255.f blue:0x8b/255.f alpha:1];
        
    [[UINavigationBar appearance] setTintColor:[RZGlobalService greenColor]];
    [[UIToolbar appearance] setTintColor:[RZGlobalService greenColor]];
    [[UIBarButtonItem appearanceWhenContainedIn:[UINavigationBar class], nil] setTintColor:[RZGlobalService greenColor]];
    [[UISegmentedControl appearance] setTintColor:[RZGlobalService greenColor]];
}

#pragma mark GHSidebarSearchViewControllerDelegate
- (void)searchResultsForText:(NSString *)text withScope:(NSString *)scope callback:(SearchResultsBlock)callback {
	callback(@[@"Foo", @"Bar", @"Baz"]);
}

- (void)searchResult:(id)result selectedAtIndexPath:(NSIndexPath *)indexPath {
	NSLog(@"Selected Search Result - result: %@ indexPath: %@", result, indexPath);
}

- (UITableViewCell *)searchResultCellForEntry:(id)entry atIndexPath:(NSIndexPath *)indexPath inTableView:(UITableView *)tableView {
	static NSString* identifier = @"GHSearchMenuCell";
	GHMenuCell* cell = [tableView dequeueReusableCellWithIdentifier:identifier];
	if (!cell) {
		cell = [[GHMenuCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:identifier];
	}
	cell.textLabel.text = (NSString *)entry;
	cell.imageView.image = [UIImage imageNamed:@"user"];
	return cell;
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
    // FBSample logic
    // if the app is going away, we close the session object
    // [FBSession.activeSession close];
    [self saveContext];
}

- (void)saveContext
{
    NSError *error = nil;
    NSManagedObjectContext *managedObjectContext = self.managedObjectContext;
    if (managedObjectContext != nil) {
        if ([managedObjectContext hasChanges] && ![managedObjectContext save:&error]) {
            // Replace this implementation with code to handle the error appropriately.
            // abort() causes the application to generate a crash log and terminate. You should not use this function in a shipping application, although it may be useful during development.
            NSLog(@"Unresolved error %@, %@", error, [error userInfo]);
            abort();
        }
    }
}


#pragma mark - Core Data stack

// Returns the managed object context for the application.
// If the context doesn't already exist, it is created and bound to the persistent store coordinator for the application.
- (NSManagedObjectContext *)managedObjectContext
{
    if (_managedObjectContext != nil) {
        return _managedObjectContext;
    }
    
    NSPersistentStoreCoordinator *coordinator = [self persistentStoreCoordinator];
    if (coordinator != nil) {
        _managedObjectContext = [[NSManagedObjectContext alloc] init];
        [_managedObjectContext setPersistentStoreCoordinator:coordinator];
    }
    return _managedObjectContext;
}

// Returns the managed object model for the application.
// If the model doesn't already exist, it is created from the application's model.
- (NSManagedObjectModel *)managedObjectModel
{
    if (_managedObjectModel != nil) {
        return _managedObjectModel;
    }
    NSURL *modelURL = [[NSBundle mainBundle] URLForResource:@"RidezuModel" withExtension:@"momd"];
    _managedObjectModel = [[NSManagedObjectModel alloc] initWithContentsOfURL:modelURL];
    return _managedObjectModel;
}

// Returns the persistent store coordinator for the application.
// If the coordinator doesn't already exist, it is created and the application's store added to it.
- (NSPersistentStoreCoordinator *)persistentStoreCoordinator
{
    if (_persistentStoreCoordinator != nil) {
        return _persistentStoreCoordinator;
    }
    
    NSURL *storeURL = [[self applicationDocumentsDirectory] URLByAppendingPathComponent:@"RidezuModel.sqlite"];
    
    NSError *error = nil;
    _persistentStoreCoordinator = [[NSPersistentStoreCoordinator alloc] initWithManagedObjectModel:[self managedObjectModel]];
    if (![_persistentStoreCoordinator addPersistentStoreWithType:NSSQLiteStoreType configuration:nil URL:storeURL options:nil error:&error]) {
        /*
         Replace this implementation with code to handle the error appropriately.
         
         abort() causes the application to generate a crash log and terminate. You should not use this function in a shipping application, although it may be useful during development.
         
         Typical reasons for an error here include:
         * The persistent store is not accessible;
         * The schema for the persistent store is incompatible with current managed object model.
         Check the error message to determine what the actual problem was.
         
         
         If the persistent store is not accessible, there is typically something wrong with the file path. Often, a file URL is pointing into the application's resources directory instead of a writeable directory.
         
         If you encounter schema incompatibility errors during development, you can reduce their frequency by:
         * Simply deleting the existing store:
         [[NSFileManager defaultManager] removeItemAtURL:storeURL error:nil]
         
         * Performing automatic lightweight migration by passing the following dictionary as the options parameter:
         @{NSMigratePersistentStoresAutomaticallyOption:@YES, NSInferMappingModelAutomaticallyOption:@YES}
         
         Lightweight migration will only work for a limited set of schema changes; consult "Core Data Model Versioning and Data Migration Programming Guide" for details.
         
         */
        NSLog(@"Unresolved error %@, %@", error, [error userInfo]);
        abort();
    }
    
    return _persistentStoreCoordinator;
}

#pragma mark - Application's Documents directory

// Returns the URL to the application's Documents directory.
- (NSURL *)applicationDocumentsDirectory
{
    return [[[NSFileManager defaultManager] URLsForDirectory:NSDocumentDirectory inDomains:NSUserDomainMask] lastObject];
}

@end
