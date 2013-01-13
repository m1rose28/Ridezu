//
//  LoginViewController.h
//  ridezu
//
//  Created by Vikram Chowdary on 22/12/12.
//  Copyright (c) 2012 Vikram Chowdary. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "AppDelegate.h"
#import "MapViewController.h"

@interface LoginViewController : UIViewController

+ (LoginViewController *)sharedInstance;

- (IBAction)facebookLogin:(id)sender;
- (void)loadMapViewController;

@end
