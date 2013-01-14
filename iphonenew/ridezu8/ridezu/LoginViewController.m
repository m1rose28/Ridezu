//
//  LoginViewController.m
//  ridezu
//
//  Created by Vikram Chowdary on 22/12/12.
//  Copyright (c) 2012 Vikram Chowdary. All rights reserved.
//

#import "LoginViewController.h"

@interface LoginViewController ()

@end

static LoginViewController *sharedInstance = nil;

@implementation LoginViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self)
    {
        // Custom initialization
    }
    return self;
}

+(LoginViewController *)sharedInstance
{
    if (nil != sharedInstance)
    {
        return sharedInstance;
    }
    
    static dispatch_once_t pred;        // Lock
    dispatch_once(&pred, ^{             // This code is called at most once per app
        sharedInstance = [[LoginViewController alloc] init];
    });
    return sharedInstance;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view.
    
    self.title = @"Login With Facebook";
    self.view.backgroundColor = [UIColor colorWithPatternImage:[UIImage imageNamed:@"mobilebackground"]];
}

- (void)viewWillAppear:(BOOL)animated
{
    [super viewWillAppear:animated];
//    NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
//    BOOL check = [defaults boolForKey:@"LoginSuccess"];
//    if (check)
//    {
//        [self performSegueWithIdentifier:@"mapView" sender:self];
//        check = !check;
//    }
}

- (void)viewDidAppear:(BOOL)animated
{
    [super viewDidAppear:animated];
}

- (IBAction)facebookLogin:(id)sender
{
    AppDelegate *appDelegate = (AppDelegate *)[[UIApplication sharedApplication] delegate];
   // if (appDelegate.facebook == nil)
   // {
        [appDelegate initializeFbSession];
   // }
   // else
   // {
    //    NSLog(@"Do Nothing");
   // }
}



- (void)loadMapViewController
{
    [self performSegueWithIdentifier:@"mapView" sender:self];
}

- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
    if ([segue.identifier isEqualToString:@"mapView"])
    {
        MapViewController *mapViewController = segue.destinationViewController;
    }
}


- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
