//
//  RZBaseViewController.m
//  Rizedu
//
//  Created by Tao Xie on 10/29/12.
//  Copyright (c) 2012 Tao Xie. All rights reserved.
//

#import "RZBaseViewController.h"

@interface RZBaseViewController ()

@end

@implementation RZBaseViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

// TODO txie, let's try to disable the PanGesture
- (void)enableSwipeToRevealGesture:(BOOL)enable {
    NSArray* gestureRecognizers = [self.navigationController.navigationBar gestureRecognizers];
    for (UIGestureRecognizer *gestureRecognizer in gestureRecognizers) {
        if ([gestureRecognizer isKindOfClass:[UIPanGestureRecognizer class]]) {
            gestureRecognizer.enabled = enable;
            break;
        }
    }
}

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view.
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
