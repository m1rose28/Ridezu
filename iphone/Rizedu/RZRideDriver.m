//
//  RZRide.m
//  Rizedu
//
//  Created by Tao Xie on 10/16/12.
//  Copyright (c) 2012 Tao Xie. All rights reserved.
//

#import "RZRideDriver.h"

@implementation RZRideDriver
- (id)initWithDict:(NSDictionary*)dict {
    self = [super init];
    if (self != nil) {
        _rideId = [dict objectForKey:@"rideid"];
        _fbId = [dict objectForKey:@"fbid"];
        _fullName = [dict objectForKey:@"name"];
        _timePreference = ([[dict objectForKey:@"timepreference"] isEqualToString:@"Y"]) ? YES : NO;
        _ridersNum = [[dict objectForKey:@"riders"] intValue];
        
        NSDateFormatter *dateFormat = [[NSDateFormatter alloc] init];
        [dateFormat setDateFormat:@"yyyy-MM-dd hh:mm:ss"];
        
        _eventTime = [dateFormat dateFromString:[dict objectForKey:@"eventtime"]];
    }
    return self;
}

- (NSString*)description {
    return [NSString stringWithFormat:@"(%@, %@, %@, %d)", _rideId, _fbId, _fullName, _ridersNum];
}
@end
