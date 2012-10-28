//
//  RZRideDetail.h
//  Rizedu
//
//  Created by Tao Xie on 10/20/12.
//  Copyright (c) 2012 Tao Xie. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface RZRideDetail : NSObject
@property (nonatomic, retain) NSString *startLocation;
@property (nonatomic, retain) NSString *endLocation;
@property (nonatomic, retain) NSString *startLongitude;
@property (nonatomic, retain) NSString *startLatitude;
@property (nonatomic, retain) NSString *endLongitude;
@property (nonatomic, retain) NSString *endLatitude;

@property (nonatomic, retain) NSString *gassaving;
@property (nonatomic, retain) NSString *co2;
@property (nonatomic, retain) NSString *amount;

@property (nonatomic, retain) NSString *date;
@property (nonatomic, retain) NSString *day;

- (id)initWithDict:(NSDictionary*)dict;
@end
