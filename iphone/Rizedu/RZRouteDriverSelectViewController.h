//
//  RZDriverSelectionViewController.h
//  RouteFlow
//
//  Created by Tao Xie on 9/27/12.
//  Copyright (c) 2012 Ridezu Inc. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "RZRideDriver.h"
#import "RZRideDetail.h"

@interface RZRouteDriverSelectViewController : UIViewController
- (id)initWithAvailableDrivers:(NSArray *)drivers andRideDetail:(RZRideDetail *)rideDetail;
@end
