//
//  WebViewController.m
//  ridezu
//
//  Created by Vikram Chowdary on 27/12/12.
//  Copyright (c) 2012 Vikram Chowdary. All rights reserved.
//

#import "WebViewController.h"
#import "MFSideMenu.h"

@interface WebViewController ()

@end

@implementation WebViewController

@synthesize webview;
@synthesize sideMenuCount;

+(WebViewController *)sharedManager
{
    static WebViewController *_sharedManager = nil;
    static dispatch_once_t oncePredicate;
    dispatch_once(&oncePredicate, ^{
        UIStoryboard *storyboard = [UIStoryboard storyboardWithName:@"MainStoryboard" bundle:nil];
        _sharedManager = (WebViewController *)[storyboard instantiateViewControllerWithIdentifier:@"loadWeb"];
                          });
    
    return _sharedManager;
}

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view.
    
    webview.delegate = self;
    
    NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
    BOOL check = [defaults boolForKey:@"Success"];
    BOOL sideMenuCheck = [defaults boolForKey:@"sideMenuCheck"];
    
    NSString *urlString;
    
    if (!sideMenuCheck)
    {
        if (!check)
        {
            urlString = [NSString stringWithFormat:@"http://stage.ridezu.com/index1.php?client=iOS&fbid=%@&seckey=%@&p=congratp",[defaults valueForKey:@"fbid"],[defaults valueForKey:@"secretKey"]];
        }
        else
        {
            urlString = [NSString stringWithFormat:@"http://stage.ridezu.com/index1.php?client=iOS&fbid=%@&seckey=%@",[defaults valueForKey:@"fbid"],[defaults valueForKey:@"secretKey"]];
        }
    }
    else if (sideMenuCheck)
    {
        [self reloadPage:sideMenuCount];
        [defaults setBool:NO forKey:@"sideMenuCheck"];
    }
    NSURL *url = [NSURL URLWithString:urlString];
    NSURLRequest *theRequest = [NSURLRequest requestWithURL:url];
    [webview loadRequest:theRequest];
    
    // this isn't needed on the rootViewController of the navigation controller
    [self.navigationController.sideMenu setupSideMenuBarButtonItem];
    
    // if you want to listen for menu open/close events
    // this is useful, for example, if you want to change a UIBarButtonItem when the menu closes
    
    
//    self.navigationController.sideMenu.menuStateEventBlock = ^(MFSideMenuStateEvent event) {
//        switch (event) {
//            case MFSideMenuStateEventMenuWillOpen:
//                // the menu will open
//                self.navigationItem.title = @"Menu Will Open!";
//                break;
//            case MFSideMenuStateEventMenuDidOpen:
//                // the menu finished opening
//                self.navigationItem.title = @"Menu Opened!";
//                break;
//            case MFSideMenuStateEventMenuWillClose:
//                // the menu will close
//                self.navigationItem.title = @"Menu Will Close!";
//                break;
//            case MFSideMenuStateEventMenuDidClose:
//                // the menu finished closing
//                self.navigationItem.title = @"Menu Closed!";
//                break;
//        }
//    };

}

- (BOOL)webView:(UIWebView *)webView shouldStartLoadWithRequest:(NSURLRequest *)request navigationType:(UIWebViewNavigationType)navigationType
{
    NSString *requestString = [[request URL] absoluteString];
    NSArray *components = [requestString componentsSeparatedByString:@"/"];
    if ([requestString isEqualToString:@"ridezu://backbutton/visible/true"])
    {
        [self middleMethod];
    }
    else if ([[components objectAtIndex:2] isEqualToString:@"title"] && [[components objectAtIndex:3] isEqualToString:@"update"])
    {
        self.title = [[components objectAtIndex:[components count]-1] stringByReplacingPercentEscapesUsingEncoding:NSUTF8StringEncoding];
    }
    
    return YES;
}

- (void)middleMethod
{
    UIButton *backButton = [[UIButton alloc] initWithFrame:CGRectMake(0, 0, 40, 30)];
    [backButton addTarget:self action:@selector(goBack) forControlEvents:UIControlEventTouchUpInside];
    [backButton setBackgroundImage:[UIImage imageNamed:@"back-arrow.png"] forState:UIControlStateNormal];
    UIBarButtonItem *leftBarButton = [[UIBarButtonItem alloc] initWithCustomView:backButton];
    self.navigationItem.leftBarButtonItem = leftBarButton;
}

- (void)goBack
{
    [webview stringByEvaluatingJavaScriptFromString:@"back()"];
    [self.navigationController.sideMenu setupSideMenuBarButtonItem];
}

- (void)reloadPage:(NSInteger)index
{
    NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
    
    NSString *urlString;
    if (index == 1)
    {
        urlString = [NSString stringWithFormat:@"http://stage.ridezu.com/index1.php?client=iOS&fbid=%@&seckey=%@&p=myridesp",[defaults valueForKey:@"fbid"],[defaults valueForKey:@"secretKey"]];
    }
    else if (index == 2)
    {
        urlString = [NSString stringWithFormat:@"http://stage.ridezu.com/index1.php?client=iOS&fbid=%@&seckey=%@&p=riderequestp",[defaults valueForKey:@"fbid"],[defaults valueForKey:@"secretKey"]];
    }
    else if (index == 3)
    {
        urlString = [NSString stringWithFormat:@"http://stage.ridezu.com/index1.php?client=iOS&fbid=%@&seckey=%@&p=ridepostp",[defaults valueForKey:@"fbid"],[defaults valueForKey:@"secretKey"]];
        
    }
    else if (index == 4)
    {
        urlString = [NSString stringWithFormat:@"http://stage.ridezu.com/index1.php?client=iOS&fbid=%@&seckey=%@&p=accountp",[defaults valueForKey:@"fbid"],[defaults valueForKey:@"secretKey"]];
        
    }
    else if (index == 5)
    {
        urlString = [NSString stringWithFormat:@"http://stage.ridezu.com/index1.php?client=iOS&fbid=%@&seckey=%@&p=profilep",[defaults valueForKey:@"fbid"],[defaults valueForKey:@"secretKey"]];
    }
    else if (index == 6)
    {
        urlString = [NSString stringWithFormat:@"http://stage.ridezu.com/index1.php?client=iOS&fbid=%@&seckey=%@&p=howitworksp",[defaults valueForKey:@"fbid"],[defaults valueForKey:@"secretKey"]];
        
    }
    else if (index == 7)
    {
        urlString = [NSString stringWithFormat:@"http://stage.ridezu.com/index1.php?client=iOS&fbid=%@&seckey=%@&p=calcp",[defaults valueForKey:@"fbid"],[defaults valueForKey:@"secretKey"]];
    }
    else if (index == 8)
    {
        urlString = [NSString stringWithFormat:@"http://stage.ridezu.com/index1.php?client=iOS&fbid=%@&seckey=%@&p=faqp",[defaults valueForKey:@"fbid"],[defaults valueForKey:@"secretKey"]];
    }
    else if (index == 9)
    {
        urlString = [NSString stringWithFormat:@"http://stage.ridezu.com/index1.php?client=iOS&fbid=%@&seckey=%@&p=termsp",[defaults valueForKey:@"fbid"],[defaults valueForKey:@"secretKey"]];
    }
    NSURL *url = [NSURL URLWithString:urlString];
    NSURLRequest *theRequest = [NSURLRequest requestWithURL:url];
    [webview loadRequest:theRequest];
}

- (void)webViewDidStartLoad:(UIWebView *)webView
{
    
}

- (void)webView:(UIWebView *)webView didFailLoadWithError:(NSError *)error
{
    
}

- (void)webViewDidFinishLoad:(UIWebView *)webView
{
    
}

- (void)javaScriptFunctions:(NSInteger)index
{
    if (index == 1)
    {
        [webview stringByEvaluatingJavaScriptFromString:@"nav1('myridesp')"];
    }
    else if (index == 2)
    {
       [webview stringByEvaluatingJavaScriptFromString:@"nav1('riderequestp')"]; 
    }
    else if (index == 3)
    {
        [webview stringByEvaluatingJavaScriptFromString:@"nav1('ridepostp')"];
        
    }
    else if (index == 4)
    {
        [webview stringByEvaluatingJavaScriptFromString:@"nav1('accountp')"];
        
    }
    else if (index == 5)
    {
        [webview stringByEvaluatingJavaScriptFromString:@"nav1('profilep')"];
    }
    else if (index == 6)
    {
        [webview stringByEvaluatingJavaScriptFromString:@"nav1('howitworksp')"];

    }
    else if (index == 7)
    {
        [webview stringByEvaluatingJavaScriptFromString:@"nav1('calcp')"];
    }
    else if (index == 8)
    {
        [webview stringByEvaluatingJavaScriptFromString:@"nav1('faqp')"];
    }
    else if (index == 9)
    {
         [webview stringByEvaluatingJavaScriptFromString:@"nav1('termsp')"];
    }
    
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
