//
//  LiveViewController.h
//  ridezu
//
//  Created by Vikram Chowdary on 23/12/12.
//  Copyright (c) 2012 Vikram Chowdary. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <MapKit/MapKit.h>
#import <CoreLocation/CoreLocation.h>
#import "AZDraggableAnnotationView.h"
#import "AppDelegate.h"
#import "MapAnnotation.h"
#import "LiveViewController.h"

@interface LiveViewController : UIViewController<MKMapViewDelegate,UITextFieldDelegate,NSURLConnectionDelegate,NSURLAuthenticationChallengeSender,CLLocationManagerDelegate,AZDraggableAnnotationViewDelegate,UIGestureRecognizerDelegate>
{
    CLLocationCoordinate2D movablecoordinates;
}

@property (nonatomic, strong) IBOutlet CLLocationManager *locationManager;
@property (nonatomic, strong) IBOutlet CLGeocoder *geoCoder;

@property (nonatomic, strong) IBOutlet UITextField *searchField;
@property (nonatomic, strong) IBOutlet MKMapView *mapview;
@property (nonatomic, strong) MKPointAnnotation *annotation;

- (void) searchCoordinatesForAddress:(NSString *)inAddress;
- (void) zoomMapAndCenterAtLatitude:(double) latitude andLongitude:(double) longitude;

- (IBAction)next:(id)sender;
- (void)loadWebController;

@end
