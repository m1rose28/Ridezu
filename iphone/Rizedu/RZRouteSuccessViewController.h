//
//  RZRouteSuccessViewController.h
//  Rizedu
//
//  Created by Tao Xie on 10/2/12.
//  Copyright (c) 2012 Ridezu Inc. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "RZRideDriver.h"
#import "RZRideDetail.h"

@interface RZRouteSuccessViewController : UIViewController
- (id)initWithDriver:(RZRideDriver*)driver andRideDetail:(RZRideDetail *)rideDetail;
@end
