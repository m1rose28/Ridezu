//
//  RZLocationPickViewController.h
//  Rizedu
//
//  Created by Tao Xie on 9/22/12.
//  Copyright (c) 2012 Ridezu Inc. All rights reserved.
//

#import <UIKit/UIKit.h>

@class RZUser;
@interface RZLocationPickViewController : RZBaseViewController

- (id)initWithType:(NSString *)type;
- (id)initWithType:(NSString *)type andUser:(RZUser*)user;
@end
