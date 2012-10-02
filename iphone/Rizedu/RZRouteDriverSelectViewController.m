//
//  RZDriverSelectionViewController.m
//  RouteFlow
//
//  Created by Tao Xie on 9/27/12.
//  Copyright (c) 2012 Tao Xie. All rights reserved.
//

#import "RZRouteDriverSelectViewController.h"

@interface RZRouteDriverSelectViewController () <UITableViewDelegate, UITableViewDataSource, UIPickerViewDelegate>{
    
}
@property (nonatomic, strong) IBOutlet UILabel *costSavingAmountLabel;
@property (nonatomic, strong) IBOutlet UILabel *gasCarbonSavingLabel;
@property (nonatomic, strong) IBOutlet UIView *routeContainerView;
@end

@implementation RZRouteDriverSelectViewController

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
    // Do any additional setup after loading the view from its nib.
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
