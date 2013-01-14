//
//  AppDelegate.h
//  ridezu
//
//  Created by Vikram Chowdary on 22/12/12.
//  Copyright (c) 2012 Vikram Chowdary. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <Facebook.h>
#import <FBSession.h>
#import "ViewController.h"
#import "LoginViewController.h"
#import "MFSideMenu.h"
#import "SideMenuViewController.h"
#import "WebViewController.h"


@interface AppDelegate : UIResponder <UIApplicationDelegate,FBSessionDelegate,FBRequestDelegate,NSURLConnectionDelegate>
{
    UIStoryboard *storyBoard;
    NSUserDefaults *defaults;
}

@property (strong, nonatomic) UIWindow *window;
@property (strong, nonatomic) ViewController *viewController;
@property (strong, nonatomic) Facebook *facebook;

- (void)initializeFbSession;
- (void) getUserInfo;

- (MFSideMenu *)sideMenu;
- (UINavigationController *)navigationController;
- (void) setupNavigationControllerApp;

@end
