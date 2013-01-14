//
//  MapAnnotation.m
//  ridezu
//
//  Created by Vikram Chowdary on 23/12/12.
//  Copyright (c) 2012 Vikram Chowdary. All rights reserved.
//

#import "MapAnnotation.h"

@implementation MapAnnotation

@synthesize coordinate,title,subtitle;

- (id)init
{
    self = [super init];
    return self;
}

- (id)initwithCordinates:(CLLocationCoordinate2D)location placeName:(NSString *)placeName description:(NSString *)description
{
    if (self != nil)
    {
        coordinate = location;
        title = placeName;
        description = description;
    }
    return self;
}

@end
