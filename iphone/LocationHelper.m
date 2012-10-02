//
//  Location.m
//  SafeBox
//
//  Created by Tao Xie on 7/23/12.
//  Copyright (c) 2012 ridezu. All rights reserved.
//

#import "LocationHelper.h"

@implementation LocationHelper
@synthesize currentLocation;
@synthesize delegate;

- (id)init {
	if (!(self = [super init])) return self;
    locationManager = [[CLLocationManager alloc] init];
    [locationManager setDelegate:self];
    locationManager.distanceFilter = 10.0f; // we don't need to be any more accurate than 10m
    locationManager.purpose = @"This may be used to obtain your reverse geocoded address";
	return self;
}

- (void) trackIt {
    [locationManager startUpdatingLocation];
}

- (void)locationManager:(CLLocationManager *)manager didUpdateToLocation:(CLLocation *)newLocation fromLocation:(CLLocation *)oldLocation
{
	// Log the kind of accuracy we got from this
	DLog(@"accuracy (%f %f)", [newLocation horizontalAccuracy], [newLocation verticalAccuracy]);
	
	// Location has been found. Create GMap URL
	CLLocationCoordinate2D loc = [newLocation coordinate];
    self.currentLocation = newLocation;
    
    [locationManager stopUpdatingLocation];
    
    if ([delegate respondsToSelector:@selector(currentLocation:)]) {
        [delegate currentLocation:self.currentLocation];
    }

//	NSString *mapString = [NSString stringWithFormat: @"http://maps.google.com/maps?q=%f,%f", loc.latitude, loc.longitude];
//	NSURL *url = [NSURL URLWithString:mapString];	
//	[[UIApplication sharedApplication] openURL:url];
}

- (void)locationManager:(CLLocationManager *)manager didFailWithError:(NSError *)error
{
    [locationManager stopUpdatingLocation];
}

@end
