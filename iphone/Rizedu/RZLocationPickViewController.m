//
//  RZLocationPickViewController.m
//  Rizedu
//
//  Created by Tao Xie on 9/22/12.
//  Copyright (c) 2012 Ridezu Inc. All rights reserved.
//

#import <MapKit/MapKit.h>
#import <QuartzCore/QuartzCore.h>
#import <CoreGraphics/CoreGraphics.h>

#import "RZLocationPickViewController.h"
#import "RZEnrollCompleteViewController.h"

#import "RZAppDelegate.h"

// using CAShapeLayer
@interface DragView : UIView {
	CGPoint startLocation;
}
@end
@implementation DragView
- (id) initWithFrame: (CGRect) aFrame
{
	self = [super initWithFrame: aFrame];
	if (!self) return NULL;
	self.userInteractionEnabled = NO;
	return self;
}
- (void)drawRect:(CGRect)rect {
    self.alpha = 0.1;
    self.layer.masksToBounds = YES;
    self.layer.cornerRadius = 40.0;
    
    CGContextRef context = UIGraphicsGetCurrentContext();
    CGContextClearRect(context, rect);
    CGContextSetStrokeColorWithColor(context, [UIColor yellowColor].CGColor);
    CGContextSetLineWidth(context, 1.0);
    
    // draw horizontal line
    CGFloat width = rect.size.width;
    CGContextMoveToPoint(context, width/2 - 5.0, width/2);
    CGContextAddLineToPoint(context, width/2 + 5.0, width/2);
    CGContextStrokePath(context);
    
    CGContextMoveToPoint(context, width/2, width/2 - 5.0);
    CGContextAddLineToPoint(context, width/2, width/2 + 5.0);
    CGContextStrokePath(context);
}
@end

@interface RZLocationPickViewController () <CLLocationManagerDelegate, MKMapViewDelegate, UITextFieldDelegate> {
    
}

@property (nonatomic, strong) CLLocationManager *locationManager;
@property (nonatomic, strong) IBOutlet UIButton *currLocationButton;
@property (nonatomic, strong) IBOutlet UITextField *addressTextField;
@property (nonatomic, strong) IBOutlet UILabel *coordinateLabel;
@property (nonatomic, strong) IBOutlet UIGlossyButton *nextButton;
@property (nonatomic, strong) IBOutlet MKMapView *mapView;

@property (readonly) CLLocationCoordinate2D currentUserCoordinate;
@property (nonatomic, copy) NSString *locationType;

@property (nonatomic, strong) CLPlacemark *placemark;
@property (nonatomic, strong) RZUser *user;

@property (nonatomic, strong) MKNetworkEngine *ridezuEngine;

- (IBAction)currLocationButtonPressed:(id)sender;
- (IBAction)nextButtonPressed:(id)sender;
@end

#define METERS_PER_MILE 1609.344

@implementation RZLocationPickViewController

- (void)currLocationButtonPressed:(id)sender {
    [_locationManager startUpdatingLocation];
}

- (void)nextButtonPressed:(id)sender {
    if ([_locationType isEqualToString:@"home"]) {
        
        // save home coordinates
        _user.homeLatitude = [NSString stringWithFormat:@"%.5f", _placemark.location.coordinate.latitude];
        _user.homeLongitude = [NSString stringWithFormat:@"%.5f", _placemark.location.coordinate.longitude];
        _user.originLatitude = _user.homeLatitude;
        _user.originLongitude = _user.homeLongitude;
        
        _user.homeAddr = [self formatString2:_placemark.subThoroughfare andThoroughfare:_placemark.thoroughfare];
        _user.homeCity = _placemark.locality;
        _user.homeState = _placemark.administrativeArea;
        _user.homeZipCode = _placemark.postalCode;
        
        UIBarButtonItem *backButton = [[UIBarButtonItem alloc]
                                       initWithTitle: @"Home"
                                       style: UIBarButtonItemStyleBordered
                                       target: nil action: nil];
        
        [self.navigationItem setBackBarButtonItem: backButton];
        
        RZLocationPickViewController *officeViewController = [[RZLocationPickViewController alloc] initWithType:@"office" andUser:_user];
        [self.navigationController pushViewController:officeViewController animated:YES];
    }
    else if ([_locationType isEqualToString:@"office"]) {
        
        _user.workLatitude = [NSString stringWithFormat:@"%.5f", _placemark.location.coordinate.latitude];
        _user.workLongitude = [NSString stringWithFormat:@"%.5f", _placemark.location.coordinate.longitude];
        _user.destLatitude = _user.workLatitude;
        _user.destLongitude = _user.workLongitude;
        
        _user.workAddr = [self formatString2:_placemark.subThoroughfare andThoroughfare:_placemark.thoroughfare];
        _user.workCity = _placemark.locality;
        _user.workState = _placemark.administrativeArea;
        _user.workZipCode = _placemark.postalCode;


        UIBarButtonItem *backButton = [[UIBarButtonItem alloc]
                                       initWithTitle: @"Office"
                                       style: UIBarButtonItemStyleBordered
                                       target: nil action: nil];
        
        [self.navigationItem setBackBarButtonItem: backButton];
        
        // THIS IS THE TIME TO SEND TO SERVER
        [self post2Server:[_user toRidezuDict]];
        
        RZEnrollCompleteViewController *enrollCompleteViewController = [[RZEnrollCompleteViewController alloc] initWithNibName:@"RZEnrollCompleteViewController" bundle:nil];
        [self.navigationController pushViewController:enrollCompleteViewController animated:YES];
    }
}

- (void)post2Server:(NSMutableDictionary*)params {
    MKNetworkOperation* op = [_ridezuEngine operationWithPath:@"ridezu/api/v/1/users" params:params httpMethod:@"POST" ssl:NO];
    [op setPostDataEncoding:MKNKPostDataEncodingTypeJSON];
    
    [op onCompletion:^(MKNetworkOperation *completedOperation) {
        NSDictionary *json = [op responseJSON];
        NSLog(@"post Ride response: %@", json);
    }
             onError:^(NSError *error) {
                 NSLog(@"%@", error);
             }];
    [_ridezuEngine enqueueOperation: op];
}

- (id)initWithType:(NSString *)type {
    return [self initWithType:type andUser:nil];
}
- (id)initWithType:(NSString *)type andUser:(RZUser*)user {
    if (self = [super initWithNibName:nil bundle:nil]) {
        self.locationType = type;
        if ([type isEqualToString:@"home"])
            self.title = @"Where do you live?";
        else if ([type isEqualToString:@"office"])
            self.title = @"Where do you work?";
	}
    _user = user;
	return self;    
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    [_nextButton setActionSheetButtonWithColor:[RZGlobalService buttonGreenColor]];

    _ridezuEngine = [[MKNetworkEngine alloc] initWithHostName:RIDEZU_HOSTNAME customHeaderFields:nil];
    
    _locationManager = [[CLLocationManager alloc] init];
    [_locationManager setDelegate:self];
    [_locationManager startUpdatingLocation];
    
    _mapView.layer.masksToBounds = YES;
    _mapView.layer.cornerRadius = 10.0;
    _mapView.mapType = MKMapTypeStandard;
    [_mapView setScrollEnabled:YES];
    _mapView.showsUserLocation = YES;
    
    _mapView.delegate = self;
    _addressTextField.delegate = self;
    
}


- (void)viewWillAppear:(BOOL)animated {
   
    [self enableSwipeToRevealGesture:NO];
    CLLocationCoordinate2D zoomLocation = [[[_mapView userLocation] location] coordinate];
    NSLog(@"Location found from Map: %f %f",zoomLocation.latitude,zoomLocation.longitude);
    
    MKCoordinateRegion viewRegion = MKCoordinateRegionMakeWithDistance(zoomLocation, 5.0*METERS_PER_MILE, 10.0*METERS_PER_MILE);
    MKCoordinateRegion adjustedRegion = [_mapView regionThatFits:viewRegion];
    [_mapView setRegion:adjustedRegion animated:YES];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (void)locationManager:(CLLocationManager *)manager didUpdateToLocation:(CLLocation *)newLocation fromLocation:(CLLocation *)oldLocation
{
	NSLog(@"accuracy (%f %f)", [newLocation horizontalAccuracy], [newLocation verticalAccuracy]);
	
	// Location has been found. Create GMap URL
	CLLocationCoordinate2D loc = [newLocation coordinate];
    NSLog(@"%.4F, %.4F", loc.latitude, loc.longitude);
    
    [_locationManager stopUpdatingLocation];
    
    // update mapView
    MKCoordinateRegion viewRegion = MKCoordinateRegionMakeWithDistance(loc, 0.5*METERS_PER_MILE, 1.5*METERS_PER_MILE);
    MKCoordinateRegion adjustedRegion = [_mapView regionThatFits:viewRegion];
    [_mapView setRegion:adjustedRegion animated:YES];
    
    double radius = 40;
    DragView *dragView = [[DragView alloc] initWithFrame:CGRectMake(CGRectGetMidX(self.mapView.frame)-radius,
                                                                      CGRectGetMidY(self.mapView.frame)-radius,
                                                                      radius*2, radius*2)];
    [self.view addSubview:dragView];
    
}

- (void)locationManager:(CLLocationManager *)manager didFailWithError:(NSError *)error
{
    [_locationManager stopUpdatingLocation];
}

- (void)mapView:(MKMapView *)mapView regionWillChangeAnimated:(BOOL)animated {
    // NSLog(@"mapView:regionWillChangeAnimated");
}
- (void)mapView:(MKMapView *)mapView regionDidChangeAnimated:(BOOL)animated {
    NSLog(@"mapView:regionDidChangeAnimated (%.4F, %.4F)", mapView.centerCoordinate.latitude, mapView.centerCoordinate.longitude);
    [_coordinateLabel setText:[NSString stringWithFormat:@"φ:%.4F, λ:%.4F", mapView.centerCoordinate.latitude, mapView.centerCoordinate.longitude]];
    CLLocationCoordinate2D loc = CLLocationCoordinate2DMake(mapView.centerCoordinate.latitude, mapView.centerCoordinate.longitude);
    
    [self performPlacemarkSearch:loc];
    
}

- (void)performPlacemarkSearch:(CLLocationCoordinate2D)loc {
    CLGeocoder *geocoder = [[CLGeocoder alloc] init];
    CLLocation *location = [[CLLocation alloc] initWithLatitude:loc.latitude longitude:loc.longitude];
    
    [geocoder reverseGeocodeLocation:location completionHandler:^(NSArray *placemarks, NSError *error) {
        NSLog(@"reverseGeocodeLocation:completionHandler: Completion Handler called!");
        if (error){
            NSLog(@"Geocode failed with error: %@", error);
            // [self displayError:error];
            return;
        }
        // NSLog(@"Received placemarks: %@", placemarks);
        if (placemarks && [placemarks count] > 0) {
            _placemark = [placemarks objectAtIndex:0];
            NSString *addressString = [self formatString:_placemark.subThoroughfare andThoroughfare:_placemark.thoroughfare Locality:_placemark.locality PostalCode:_placemark.postalCode];
            NSLog(@"%@, %@, %@", _placemark.name, _placemark.subThoroughfare, _placemark.thoroughfare);
            
            [_addressTextField setText:addressString];
        }
    }];
    
}
- (NSString*)formatString2:(NSString*)subThoroughfare andThoroughfare:(NSString*)thoroughfare {
    NSString *addressString;
    if (!subThoroughfare) {
        if (!thoroughfare) {
            addressString = @"";
        }
        else {
            addressString = thoroughfare;
        }
    }
    else {
        addressString = [NSString stringWithFormat:@"%@ %@", subThoroughfare, thoroughfare];
    }
    return addressString;
}

- (NSString*)formatString:(NSString*)subThoroughfare andThoroughfare:(NSString*)thoroughfare Locality:(NSString*)locality PostalCode:(NSString*)postalCode {
    NSString *addressString;
    if (!subThoroughfare) {
        if (!thoroughfare) {
            addressString = [NSString stringWithFormat:@"%@ %@", locality, postalCode];
        }
        else {
            addressString = [NSString stringWithFormat:@"%@, %@ %@", thoroughfare, locality, postalCode];
        }
    }
    else {
        addressString = [NSString stringWithFormat:@"%@ %@, %@ %@", subThoroughfare, thoroughfare, locality, postalCode];
    }
    return addressString;
}

- (BOOL)textFieldShouldReturn:(UITextField *)textField {
    CLGeocoder *geocoder = [[CLGeocoder alloc] init];
    [_addressTextField resignFirstResponder];
    
    [geocoder geocodeAddressString:_addressTextField.text completionHandler:^(NSArray *placemarks, NSError *error) {
        NSLog(@"geocodeAddressString:completionHandler: Completion Handler called!");
        if (error)
        {
            NSLog(@"Geocode failed with error: %@", error);
            return;
        }
        
        NSLog(@"Received placemarks: %@", placemarks);
        if (placemarks) {
            if ([placemarks count] > 1) {
                NSLog(@"More than 1 placemarks returned");
            }
            CLPlacemark *placemark = [placemarks objectAtIndex:0];
            MKCoordinateRegion region =  MKCoordinateRegionMakeWithDistance(placemark.location.coordinate, 200, 200);
            [_mapView setRegion:region animated:YES];
        }
    }];
    return YES;
}
@end
