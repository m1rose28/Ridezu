//
//  Location.h
//  SafeBox
//
//  Created by Tao Xie on 7/23/12.
//  Copyright (c) 2012 ridezu. All rights reserved.
//

#import <Foundation/Foundation.h>
#import <CoreLocation/CoreLocation.h>
#import <CoreLocation/CLLocationManagerDelegate.h>

@protocol LocationHelperDelegate;

@interface LocationHelper : NSObject <CLLocationManagerDelegate> {
    CLLocationManager *locationManager;
}
@property (strong, nonatomic) CLLocation *currentLocation;
@property (nonatomic,assign) id <LocationHelperDelegate> delegate;

- (void) trackIt;
@end

@protocol LocationHelperDelegate <NSObject>
@optional
- (void) currentLocation:(CLLocation *)location;
@end
