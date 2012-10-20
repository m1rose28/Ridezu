//
//  RZRide.h
//  Rizedu
//
//  Created by Tao Xie on 10/16/12.
//  Copyright (c) 2012 Tao Xie. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface RZRide : NSObject
@property (nonatomic, retain) NSString *rideId;
@property (nonatomic, retain) NSString *fbId;
@property (nonatomic, retain) NSString *fullName;
@property (nonatomic, assign) Boolean timePreference;
@property (nonatomic, assign) int ridersNum;
@property (nonatomic, retain) NSDate *eventTime;

- (id)initWithDict:(NSDictionary*)dict;
@end
