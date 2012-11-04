//
//  Copyright (c) 2012 Parse. All rights reserved.

#import <UIKit/UIKit.h>

@interface LoginViewController : RZBaseViewController

@property (nonatomic, strong) IBOutlet UIActivityIndicatorView *activityIndicator;

- (IBAction)loginButtonTouchHandler:(id)sender;

@end
