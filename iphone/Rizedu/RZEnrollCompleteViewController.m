//
//  RZEnrollCompleteViewController.m
//  Rizedu
//
//  Created by Tao Xie on 9/24/12.
//  Copyright (c) 2012 Tao Xie. All rights reserved.
//

#import "RZEnrollCompleteViewController.h"
#import "RZAppDelegate.h"

@interface RZEnrollCompleteViewController () {
    
}
@property (nonatomic, weak) IBOutlet UIGlossyButton *getStartedButton;
@property (nonatomic, weak) IBOutlet UITextView *subjectTextView;
@end

@implementation RZEnrollCompleteViewController

- (void)startedButtonPressed:(id)sender {
    [self.navigationController popToRootViewControllerAnimated:YES];
    RZAppDelegate* delegate = (RZAppDelegate*)[[UIApplication sharedApplication] delegate];
    NSIndexPath *myIndexPath = [NSIndexPath indexPathForRow:0 inSection:1];
    [delegate.menuController selectRowAtIndexPath:myIndexPath animated:YES scrollPosition:UITableViewScrollPositionNone];
}

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        self.title = @"Completed";
        // [_getStartedButton addTarget:self action:@selector(startedButtonPressed:) forControlEvents:UIControlEventTouchDown];
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    NSString *fullName = [RZGlobalService activeUserName];
    if (fullName) {
        NSArray *tokens = [fullName componentsSeparatedByString:@" "];
        if ([tokens count] > 0) {
            self.subjectTextView.text = [NSString stringWithFormat:@"Congratulations %@, you're new signed up for Ridezu.", [tokens objectAtIndex:0]];
        }
    }
    [_getStartedButton addTarget:self action:@selector(startedButtonPressed:) forControlEvents:UIControlEventTouchDown];
    [_getStartedButton setActionSheetButtonWithColor:[RZGlobalService buttonGreenColor]];

    // Do any additional setup after loading the view from its nib.
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
