//
//  RZRouteSuccessViewController.m
//  Rizedu
//
//  Created by Tao Xie on 10/2/12.
//  Copyright (c) 2012 Ridezu Inc. All rights reserved.
//

#import "RZRouteSuccessViewController.h"
#import "DriverTableViewCell.h"
#import <QuartzCore/QuartzCore.h>

#import "UIAlertView+Blocks.h"


@interface RZRouteSuccessViewController () <UITableViewDelegate, UITableViewDataSource, UIPickerViewDelegate>{
    
}
@property (nonatomic, strong) IBOutlet UILabel *costSavingAmountLabel;
@property (nonatomic, strong) IBOutlet UILabel *gasCarbonSavingLabel;
@property (nonatomic, strong) IBOutlet UIView *routeContainerView;

@property (nonatomic, strong) IBOutlet UIView *detailContainerView;

@property (nonatomic, weak) IBOutlet UITextView *congratulateTextView;
@property (nonatomic, weak) IBOutlet UILabel *nameLabel;
@property (nonatomic, weak) IBOutlet UIImageView *avatarImageView;
@property (nonatomic, weak) IBOutlet UILabel *debugLabel;
@property (nonatomic, weak) IBOutlet UIButton *submitButton;

@property (nonatomic, strong) RZRideDriver *driver;
@property (nonatomic, strong) RZRideDetail *rideDetail;

@end


@implementation RZRouteSuccessViewController

- (void)submitRequest:(id)sender {
    NSDictionary *params = @{@"fbid" : @"500012114"};
    NSString *path = [NSString stringWithFormat:@"ridezu/api/v/1/rides/rideid/%@/rider", _driver.rideId];
    MKNetworkOperation* op = [[RZGlobalService singleton].ridezuEngine operationWithPath:path params:(NSMutableDictionary*)params httpMethod:@"PUT" ssl:NO];
    [op setPostDataEncoding:MKNKPostDataEncodingTypeJSON];
    
    [op onCompletion:^(MKNetworkOperation *completedOperation) {
        NSDictionary *json = [op responseJSON];
        NSLog(@"response: %@", json);
        // alert
        RIButtonItem *cancelItem = [RIButtonItem item];
        cancelItem.label = @"OK";
        cancelItem.action = ^{
            // Better redirect to somewhere else.
        };
        NSString *message = [NSString stringWithFormat:@"Sweet! You're set to meet %@ @ %@ at %@. ",
                             self.driver.fullName, self.rideDetail.date, self.rideDetail.startLocation];
        UIAlertView *alertView = [[UIAlertView alloc] initWithTitle:@"Congratulations"
                                                            message:message
                                                   cancelButtonItem:cancelItem
                                                   otherButtonItems:nil, nil];
        [alertView show];
        
    }
    onError:^(NSError *error) {
                 NSLog(@"%@", error);
    }];
    [[RZGlobalService singleton].ridezuEngine enqueueOperation: op];
}

- (id)initWithDriver:(RZRideDriver*)driver andRideDetail:(RZRideDetail *)rideDetail{
    self = [self initWithNibName:@"RZRouteSuccessViewController" bundle:nil];
    if (self) {                    
        self.driver = driver;
        self.rideDetail = rideDetail;
    }
    return self;
}
- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
        self.title = @"Request a Ride";
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    _routeContainerView.layer.masksToBounds = YES;
    _routeContainerView.layer.cornerRadius = 10.0;
    
    _gasCarbonSavingLabel.layer.masksToBounds = YES;
    _gasCarbonSavingLabel.layer.cornerRadius = 5.0;
    
    _costSavingAmountLabel.layer.masksToBounds = YES;
    _costSavingAmountLabel.layer.cornerRadius = 5.0;
       
    UIImage *backButtonImage = [UIImage imageNamed:@"arrow_left.png"];
    UIBarButtonItem *customItem = [[UIBarButtonItem alloc] initWithImage:backButtonImage style:UIBarButtonItemStylePlain target:self.navigationController action:@selector(popViewControllerAnimated:)];
    [self.navigationItem setLeftBarButtonItem: customItem];
    
    // fill in user data
    self.nameLabel.text = self.driver.fullName;
    self.congratulateTextView.text = [NSString stringWithFormat:@"Sweet! You're set to meet %@ @ %@ at %@. ",
                                   self.driver.fullName, self.rideDetail.date, self.rideDetail.startLocation];
    self.debugLabel.text = [NSString stringWithFormat:@"%@ (%@)", self.driver.rideId, self.driver.fullName];
    [_submitButton addTarget:self action:@selector(submitRequest:) forControlEvents:UIControlEventTouchUpInside];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}


@end
