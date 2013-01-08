//
//  AppDelegate.m
//  ridezu
//
//  Created by Vikram Chowdary on 22/12/12.
//  Copyright (c) 2012 Vikram Chowdary. All rights reserved.
//

#import "AppDelegate.h"

#pragma mark -
#pragma mark Private Interface
@interface AppDelegate ()
@end


@implementation AppDelegate;

@synthesize viewController;
@synthesize facebook;

- (BOOL)application:(UIApplication *)application didFinishLaunchingWithOptions:(NSDictionary *)launchOptions
{
    // Override point for customization after application launch
    self.window = [[UIWindow alloc] initWithFrame:[[UIScreen mainScreen] bounds]];

    storyBoard = [UIStoryboard storyboardWithName:@"MainStoryboard" bundle:nil];
    viewController = (ViewController *)[storyBoard instantiateViewControllerWithIdentifier:@"viewController"];
    
    self.window.rootViewController = viewController;
    [self.window makeKeyAndVisible];
    
    return YES;
}


- (WebViewController *)webController
{
    return (WebViewController *)[storyBoard instantiateViewControllerWithIdentifier:@"loadWeb"];
}

- (UINavigationController *)navigationController {
    return [[UINavigationController alloc]
            initWithRootViewController:[self webController]];
}

- (MFSideMenu *)sideMenu {
    SideMenuViewController *sideMenuController = [[SideMenuViewController alloc] init];
    UINavigationController *navigationController = [self navigationController];
    
    MFSideMenuOptions options = MFSideMenuOptionMenuButtonEnabled|MFSideMenuOptionBackButtonEnabled
    |MFSideMenuOptionShadowEnabled;
    MFSideMenuPanMode panMode = MFSideMenuPanModeNavigationBar|MFSideMenuPanModeNavigationController;
    
    MFSideMenu *sideMenu = [MFSideMenu menuWithNavigationController:navigationController
                                                 sideMenuController:sideMenuController
                                                           location:MFSideMenuLocationLeft
                                                            options:options
                                                            panMode:panMode];
    
    sideMenuController.sideMenu = sideMenu;
    
    return sideMenu;
}

- (void) setupNavigationControllerApp {
    self.window.rootViewController = [self sideMenu].navigationController;
    [self.window makeKeyAndVisible];
}

- (void)initializeFbSession
{
    NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
    
    facebook = [[Facebook alloc] initWithAppId:@"443508415694320" andDelegate:self];
    
    if ([defaults objectForKey:@"FBAccessTokenKey"] && [defaults objectForKey:@"FBExpirationDateKey"])
    {
        facebook.accessToken = [defaults objectForKey:@"FBAccessTokenKey"];
        facebook.expirationDate = [defaults objectForKey:@"FBExpirationDateKey"];
    }
    if (![facebook isSessionValid])
    {
        NSArray* permissions = [[NSArray alloc] initWithObjects:
                                @"publish_stream",@"publish_actions", @"email",@"user_about_me",@"offline_access", nil];
        
        [facebook authorize:permissions];
        
    }
}

- (void)fbDidLogin
{
    NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
    [defaults setObject:[facebook accessToken] forKey:@"FBAccessTokenKey"];
    [defaults setObject:[facebook expirationDate] forKey:@"FBExpirationDateKey"];
   // [defaults setBool:YES forKey:@"LoginSuccess"];
    [defaults synchronize];
    
    //Get User Info
    [self getUserInfo];
    
    //Launch The mapView
    UIViewController *loginViewController = (UIViewController *)[storyBoard instantiateViewControllerWithIdentifier:@"loginViewController"];
    self.window.rootViewController = loginViewController;
    [loginViewController performSegueWithIdentifier:@"mapView" sender:self];
}

- (void) getUserInfo
{
    [facebook requestWithGraphPath:@"me" andDelegate:self];
}

- (void)request:(FBRequest *)request didLoad:(id)result
{
    if ([result isKindOfClass:[NSDictionary class]])
    {
        NSDictionary *json = result;
        
        NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
        [defaults setValue:[json valueForKey:@"id"] forKey:@"fbid"];
        [defaults setValue:[json valueForKey:@"first_name"] forKey:@"fname"];
        [defaults setValue:[json valueForKey:@"last_name"] forKey:@"lname"];
        [defaults setValue:[json valueForKey:@"email"] forKey:@"email"];
        
        NSError *error;
        
        NSData* jsonData = [NSJSONSerialization dataWithJSONObject:json
                                                           options:NSJSONWritingPrettyPrinted
                                                             error:&error];
        NSString *profileBlobstr = [[NSString alloc] initWithData:jsonData encoding:NSUTF8StringEncoding];
        
        [defaults setValue:profileBlobstr forKey:@"profileBlob"];
        
        [defaults synchronize];
    }
    
//    NSData *data = [NSData dataWithContentsOfURL:[NSURL URLWithString:[NSString stringWithFormat:@"https://graph.facebook.com/me/?access_token=%@",facebook.accessToken]]];
//    NSDictionary *response = [NSJSONSerialization JSONObjectWithData:data options:kNilOptions error:nil];
}

// For iOS 4.2+ support
- (BOOL)application:(UIApplication *)application openURL:(NSURL *)url
  sourceApplication:(NSString *)sourceApplication annotation:(id)annotation
{
    return [self.facebook handleOpenURL:url];
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

- (void)applicationWillTerminate:(UIApplication *)application
{
    // Called when the application is about to terminate. Save data if appropriate. See also applicationDidEnterBackground:.
}

@end
