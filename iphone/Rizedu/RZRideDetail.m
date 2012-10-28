//
//  RZRideDetail.m
//  Rizedu
//
//  Created by Tao Xie on 10/20/12.
//  Copyright (c) 2012 Tao Xie. All rights reserved.
//

#import "RZRideDetail.h"

@implementation RZRideDetail

- (id)initWithDict:(NSDictionary*)dict {
    self = [super init];
    if (self != nil) {
        _startLocation = [dict objectForKey:@"start"];
        _endLocation = [dict objectForKey:@"end"];
        
        NSArray *startCoordinates = ([dict objectForKey:@"startlatlong"] == nil)
        ? nil
        : [[dict objectForKey:@"startlatlong"] componentsSeparatedByString:@","];
        
        NSArray *endCoordinates = ([dict objectForKey:@"endlatlong"] == nil)
        ? nil
        : [[dict objectForKey:@"endlatlong"] componentsSeparatedByString:@","];
        
        _startLatitude = [startCoordinates objectAtIndex:0];
        _startLongitude = [startCoordinates objectAtIndex:1];
        
        _endLatitude = [endCoordinates objectAtIndex:0];
        _endLongitude = [endCoordinates objectAtIndex:1];
        
        _gassaving = [dict objectForKey:@"gassaving"];
        _co2 = [dict objectForKey:@"co2"];
        _amount = [dict objectForKey:@"amount"];
        
        _date = [dict objectForKey:@"date"];
        _day = [dict objectForKey:@"day"];
    }
    return self;

}

@end
