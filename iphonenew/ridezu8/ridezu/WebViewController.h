//
//  WebViewController.h
//  ridezu
//
//  Created by Vikram Chowdary on 27/12/12.
//  Copyright (c) 2012 Vikram Chowdary. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <QuartzCore/QuartzCore.h>
#import "AppDelegate.h"


@interface WebViewController : UIViewController<UIWebViewDelegate>
{
    UIView *indicatorView;
    UILabel *centerMessageLabel;
    UIActivityIndicatorView *m_loadingIndicator;
    UIWindow *m_window;
}

@property (nonatomic, strong) IBOutlet UIWebView *webview;
@property (nonatomic, assign) NSInteger sideMenuCount;

+(WebViewController *)sharedManager;

- (void)javaScriptFunctions:(NSInteger)index;
- (void)middleMethod;
- (void)goBack;

- (void)reloadPage:(NSInteger)index;

@end
