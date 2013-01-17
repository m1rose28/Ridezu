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


@implementation AppDelegate

@synthesize viewController;
@synthesize facebook;

- (BOOL)application:(UIApplication *)application didFinishLaunchingWithOptions:(NSDictionary *)launchOptions
{
    // Override point for customization after application launch
    self.window = [[UIWindow alloc] initWithFrame:[[UIScreen mainScreen] bounds]];

    storyBoard = [UIStoryboard storyboardWithName:@"MainStoryboard" bundle:nil];
    
    [facebook logout];
    
    defaults = [NSUserDefaults standardUserDefaults];
    
    NSString *fbStr = [defaults valueForKey:@"fbid"];
    NSString *secStr = [defaults valueForKey:@"secretKey"];
    
    [[UINavigationBar appearance] setBackgroundImage:[UIImage imageNamed:@"titlebar"] forBarMetrics:UIBarMetricsDefault];

    if ([fbStr length] > 5 && [secStr length] > 5)
    {
        [defaults setBool:YES forKey:@"Success"];
        [self setupNavigationControllerApp];
    }
    else
    {
        [defaults setBool:NO forKey:@"Success"];
        viewController = (ViewController *)[storyBoard instantiateViewControllerWithIdentifier:@"viewController"];
        
        self.window.rootViewController = viewController;
        [self.window makeKeyAndVisible];
    }
    
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
    defaults = [NSUserDefaults standardUserDefaults];
    
    facebook = [[Facebook alloc] initWithAppId:@"443508415694320" andDelegate:self];
    
    if ([defaults objectForKey:@"FBAccessTokenKey"] && [defaults objectForKey:@"FBExpirationDateKey"])
    {
      //  facebook.accessToken = [defaults objectForKey:@"FBAccessTokenKey"];
      //  facebook.expirationDate = [defaults objectForKey:@"FBExpirationDateKey"];
        
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
    defaults = [NSUserDefaults standardUserDefaults];
    [defaults setObject:[facebook accessToken] forKey:@"FBAccessTokenKey"];
    [defaults setObject:[facebook expirationDate] forKey:@"FBExpirationDateKey"];
   // [defaults setBool:YES forKey:@"LoginSuccess"];
    [defaults synchronize];
    
    //Get User Info
    [self getUserInfo];
}

- (void)fbDidNotLogin:(BOOL)cancelled
{
    
}

- (void)fbDidExtendToken:(NSString *)accessToken expiresAt:(NSDate *)expiresAt
{
    
}

- (void)fbSessionInvalidated
{
    
}

- (void)fbDidLogout
{
    
}

- (void) getUserInfo
{
    [facebook requestWithGraphPath:@"me" andDelegate:self];
    
    NSURL *url = [NSURL URLWithString:[NSString stringWithFormat:@"http://stage.ridezu.com/fbauth2.php?accesstoken=%@",[facebook accessToken]]];
    
    NSMutableURLRequest *request = [NSMutableURLRequest requestWithURL:url
                                                           cachePolicy:NSURLRequestUseProtocolCachePolicy timeoutInterval:60.0];
    
    NSArray *keys = [NSArray arrayWithObjects:@"accesstoken", nil];
    
    
    NSArray *objects = [NSArray arrayWithObjects:[defaults valueForKey:@"FBAccessTokenKey"],
                        nil];
    
    NSDictionary *jsonDict = [NSDictionary dictionaryWithObjects:objects forKeys:keys];
    
    //convert object to data
    NSError *error;
    NSData* jsonData = [NSJSONSerialization dataWithJSONObject:jsonDict
                                                       options:NSJSONWritingPrettyPrinted
                                                         error:&error];

    
    [request setHTTPMethod:@"POST"];
    [request setValue:@"application/json" forHTTPHeaderField:@"Content-Type"];
    [request setValue:[NSString stringWithFormat:@"%d", [jsonData length]] forHTTPHeaderField:@"Content-Length"];
    [request setHTTPBody:jsonData];

    
    NSURLConnection *connection = [[NSURLConnection alloc]initWithRequest:request delegate:self];
    [connection start];

}

- (void)connection:(NSURLConnection *)connection didFailWithError:(NSError *)error
{
    NSLog(@"%@",[error description]);
}

- (void)connection:(NSURLConnection *)connection didReceiveData:(NSData *)data
{
    // NSString *jsonString = [[NSString alloc] initWithData:data encoding:NSUTF8StringEncoding];
    
    //   NSData *tempData = [jsonString dataUsingEncoding:NSUTF8StringEncoding];
    
    NSDictionary *tempDict = [NSJSONSerialization JSONObjectWithData:data options:kNilOptions error:nil];
    
    NSString *fbStr = [tempDict valueForKey:@"fbid"];
    NSString *secStr = [tempDict valueForKey:@"seckey"];
    
    [defaults setValue:fbStr forKey:@"fbid"];
    [defaults setValue:secStr forKey:@"secretKey"];
    
    if ([secStr isEqualToString:@"na"] && ![fbStr isEqualToString:@"na"])
    {
        [defaults setBool:NO forKey:@"Success"];
        //Launch The mapView
        UIViewController *loginViewController = (UIViewController *)[storyBoard instantiateViewControllerWithIdentifier:@"loginViewController"];
        self.window.rootViewController = loginViewController;
        [loginViewController performSegueWithIdentifier:@"mapView" sender:self];
    }
    else if (![secStr isEqualToString:@"na"] && ![fbStr isEqualToString:@"na"])
    {
        [defaults setBool:YES forKey:@"Success"];
        [self setupNavigationControllerApp];
    }
    
}

- (void)request:(FBRequest *)request didLoad:(id)result
{
    if ([result isKindOfClass:[NSDictionary class]])
    {
        NSDictionary *json = result;
        
        defaults = [NSUserDefaults standardUserDefaults];
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
