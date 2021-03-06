//
//  RZAppDelegate.h
//  Rizedu
//
//  Created by Tao Xie on 9/22/12.
//  Copyright (c) 2012 Ridezu Inc. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "GHMenuViewController.h"
#import "GHRevealViewController.h"

@interface RZAppDelegate : UIResponder <UIApplicationDelegate>

@property (strong, nonatomic) UIWindow *window;
@property (strong, nonatomic) UINavigationController *navigationController;

@property (nonatomic, strong) GHRevealViewController *revealController;
@property (nonatomic, strong) GHMenuViewController *menuController;

@property (nonatomic, strong) UINavigationController *testUsersNav;

- (void) applicationDidFinishLaunching:(NSNotification*) notice ;
@end
