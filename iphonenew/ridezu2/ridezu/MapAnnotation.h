//
//  MapAnnotation.h
//  ridezu
//
//  Created by Vikram Chowdary on 23/12/12.
//  Copyright (c) 2012 Vikram Chowdary. All rights reserved.
//

#import <Foundation/Foundation.h>
#import <MapKit/MapKit.h>

@interface MapAnnotation : NSObject<MKAnnotation>
{
    CLLocationCoordinate2D coordinate;
    NSString *title;
    NSString *subTitle;
}

@property (nonatomic, readonly) CLLocationCoordinate2D coordinate;
@property (nonatomic, readonly) NSString *title;
@property (nonatomic, readonly) NSString *subtitle;

- (id)initwithCordinates:(CLLocationCoordinate2D )location placeName:(NSString *)placeName description:(NSString *)description;

@end
