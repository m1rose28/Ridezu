//
//  MapViewController.h
//  ridezu
//
//  Created by Vikram Chowdary on 22/12/12.
//  Copyright (c) 2012 Vikram Chowdary. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <MapKit/MapKit.h>
#import <CoreLocation/CoreLocation.h>
#import "MapAnnotation.h"

@interface MapViewController : UIViewController<MKMapViewDelegate,UISearchBarDelegate,CLLocationManagerDelegate>


@property (nonatomic, strong) IBOutlet CLLocationManager *locationManager;
@property (nonatomic, strong) IBOutlet CLGeocoder *geoCoder;
@property (nonatomic, strong) IBOutlet UISearchBar *searchbar;
@property (nonatomic, strong) IBOutlet MKMapView *mapview;

- (void) searchCoordinatesForAddress:(NSString *)inAddress;
- (void) zoomMapAndCenterAtLatitude:(double) latitude andLongitude:(double) longitude;

@end
