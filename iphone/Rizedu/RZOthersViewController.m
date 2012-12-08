//
//  RZOthersViewController.m
//  Rizedu
//
//  Created by Tao Xie on 11/4/12.
//  Copyright (c) 2012 Tao Xie. All rights reserved.
//

#import "RZOthersViewController.h"
#define BASE_URL @"http://www.ridezu.com"

@interface RZOthersViewController () {
    RevealBlock _revealBlock;
}
@property IBOutlet UIWebView *webView;
@property (nonatomic, strong) NSString *path;
@property (nonatomic) SEL backPressed;
@end

@implementation RZOthersViewController

- (void)revealSidebar {
	_revealBlock();
}

- (id)initWithPath:(NSString*)path andTitle:(NSString*)title withRevealBlock:(RevealBlock)revealBlock{
    if ((self = [[RZOthersViewController alloc] initWithNibName:@"RZOthersViewController" bundle:nil])) {
        self.path = path;
        self.title = title;
        
        UIImage *slideImage = [UIImage imageNamed:@"menu.png"];
        _revealBlock = revealBlock;
        
        UIBarButtonItem *slideButtonItem = [[UIBarButtonItem alloc] initWithImage:slideImage style:UIBarButtonItemStylePlain target:self action:@selector(revealSidebar)];
        self.navigationItem.leftBarButtonItem = slideButtonItem;
        
        return self;
    }
    return nil;
}

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        _webView.delegate = self;
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    _webView.delegate = self;
    
    NSString *fullUrl =
    [NSString stringWithFormat:@"http://stage.ridezu.com/index1.php?fbid=%@&seckey=%@&client=iOS",
        @"500012114",@"f6462731d06d181532acd85a5791621a"];

    NSLog(@"Loading %@", fullUrl);

    [_webView loadRequest:[NSURLRequest requestWithURL:[NSURL URLWithString:fullUrl]]];
    
}

-(void)webViewDidFinishLoad:(UIWebView *)adWebView1 {
    
    NSLog(@"Path: %@", self.path);
    
    [_webView stringByEvaluatingJavaScriptFromString:[NSString stringWithFormat:@"nav1('%@');", self.path]];
    
}

- (void)webView:(UIWebView *)webView didFailLoadWithError:(NSError *)error
{
    // load error, hide the activity indicator in the status bar
    [UIApplication sharedApplication].networkActivityIndicatorVisible = NO;
    
    // report the error inside the webview
    NSString* errorString = [NSString stringWithFormat:
                             @"<html><center><font size=+5 color='red'>An error occurred:<br>%@</font></center></html>",
                             error.localizedDescription];
    [_webView loadHTMLString:errorString baseURL:nil];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}


- (void) webView:(UIWebView*)backPressed:(NSString*) navspec
{
    NSLog(@"backPressed");
}

- (BOOL)webView:(UIWebView *)webViewRef shouldStartLoadWithRequest:(NSURLRequest *)request navigationType:(UIWebViewNavigationType)navigationType {
    if (navigationType == UIWebViewNavigationTypeLinkClicked) {

        NSURL *URL = [request URL];    
        if ([[URL scheme] isEqualToString:@"ridezu"]) {
            if ([[URL host] isEqualToString:@"showbackbutton"]) {
//                [_webView stringByEvaluatingJavaScriptFromString:@"nav1('termsp')"];
                
                // set leftBarButtonItem to "Back"
                UIBarButtonItem *backButton = [[UIBarButtonItem alloc]
                                               initWithTitle: @"Back"
                                               style: UIBarButtonItemStyleBordered
                                               target: self
                                               action: @selector(backPressed:)];
                
                [self.navigationItem setBackBarButtonItem: backButton];
//                self.navigationItem.backBarButtonItem = backButton;
                self.navigationItem.leftBarButtonItem = backButton;
                 
            } else if ([[URL host] isEqualToString:@"updatetitle"]) {
                //hold a reference to this webview for calling back to the webview later
                _webView = webViewRef;
                [self setTitle:[URL path]];
            }
            return NO;
        }
    }
    return YES;
}
@end
