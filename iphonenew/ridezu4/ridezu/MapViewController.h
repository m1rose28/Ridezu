//
//  MapViewController.h
//  ridezu
//
//  Created by Vikram Chowdary on 22/12/12.
//  Copyright (c) 2012 Vikram Chowdary. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <MapKit/MapKit.h>
#import "AZDraggableAnnotationView.h"
#import <CoreLocation/CoreLocation.h>
#import "MapAnnotation.h"

@interface MapViewController : UIViewController<MKMapViewDelegate,CLLocationManagerDelegate,UITextFieldDelegate,AZDraggableAnnotationViewDelegate,UIGestureRecognizerDelegate>
{
    CLLocationCoordinate2D movableCoordinates;
}


@property (nonatomic, strong) IBOutlet CLLocationManager *locationManager;
@property (nonatomic, strong) IBOutlet CLGeocoder *geoCoder;
@property (nonatomic, strong) IBOutlet UITextField *searchField;
@property (nonatomic, strong) IBOutlet MKMapView *mapview;
@property (nonatomic, strong) MKPointAnnotation *annotation;

- (void) searchCoordinatesForAddress:(NSString *)inAddress;
- (void) zoomMapAndCenterAtLatitude:(double) latitude andLongitude:(double) longitude;

@end
