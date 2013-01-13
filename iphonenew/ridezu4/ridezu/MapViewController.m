//
//  MapViewController.m
//  ridezu
//
//  Created by Vikram Chowdary on 22/12/12.
//  Copyright (c) 2012 Vikram Chowdary. All rights reserved.
//

#import "MapViewController.h"

@interface MapViewController ()

@end

@implementation MapViewController

@synthesize locationManager;
@synthesize geoCoder;
@synthesize searchField;
@synthesize mapview;
@synthesize annotation;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view.
    locationManager.delegate = self;
    [locationManager startUpdatingLocation];
    mapview.delegate = self;
    searchField.delegate = self;
    
    UITapGestureRecognizer *singleTapRecognizer = [[UITapGestureRecognizer alloc] initWithTarget:self action:@selector(handleSingleTapGesture:)];
    singleTapRecognizer.numberOfTapsRequired = 1;
    singleTapRecognizer.numberOfTouchesRequired = 1;
    [mapview addGestureRecognizer:singleTapRecognizer];
    
    UITapGestureRecognizer *doubleTapRecognizer = [[UITapGestureRecognizer alloc] init];
    doubleTapRecognizer.numberOfTapsRequired = 2;
    doubleTapRecognizer.numberOfTouchesRequired = 1;
    
    // In order to pass double-taps to the underlying MKMapView the delegate
    // for this recognizer (self) needs to return YES from
    // gestureRecognizer:shouldRecognizeSimultaneouslyWithGestureRecognizer:
    doubleTapRecognizer.delegate = self;
    [mapview addGestureRecognizer:doubleTapRecognizer];
    
    // This delays the single-tap recognizer slightly and ensures that it
    // will _not_ fire if there is a double-tap
    [singleTapRecognizer requireGestureRecognizerToFail:doubleTapRecognizer];
}

- (void)viewDidAppear:(BOOL)animated
{
    [super viewDidAppear:animated];
}

- (void)moveAnnotationToCoordinate:(CLLocationCoordinate2D)coordinate
{
    if (annotation) {
        [UIView beginAnimations:[NSString stringWithFormat:@"slideannotation%@", annotation] context:nil];
        [UIView setAnimationCurve:UIViewAnimationCurveEaseOut];
        [UIView setAnimationDuration:0.2];
        
        annotation.coordinate = coordinate;
        
        [UIView commitAnimations];
    } else {
        annotation = [[MKPointAnnotation alloc] init];
        annotation.coordinate = movableCoordinates;
        
        [mapview addAnnotation:annotation];
    }
}

#pragma mark MKMapViewDelegate

- (MKAnnotationView *)mapView:(MKMapView *)mv viewForAnnotation:(id <MKAnnotation>)anno
{
    MKAnnotationView *annotationView = [mv dequeueReusableAnnotationViewWithIdentifier:@"DraggableAnnotationView"];
    
    if (!annotationView) {
        annotationView = [[AZDraggableAnnotationView alloc] initWithAnnotation:anno reuseIdentifier:@"DraggableAnnotationView"];
    }
    
    ((AZDraggableAnnotationView *)annotationView).delegate = self;
    ((AZDraggableAnnotationView *)annotationView).mapView = mapview;
    
    return annotationView;
}

#pragma mark UIGestureRecognizerDelegate methods

/**
 Asks the delegate if two gesture recognizers should be allowed to recognize gestures simultaneously.
 */
- (BOOL)gestureRecognizer:(UIGestureRecognizer *)gestureRecognizer shouldRecognizeSimultaneouslyWithGestureRecognizer:(UIGestureRecognizer *)otherGestureRecognizer
{
    // Returning YES ensures that double-tap gestures propogate to the MKMapView
    return YES;
}

#pragma mark UIGestureRecognizer handlers

- (void)handleSingleTapGesture:(UIGestureRecognizer *)gestureRecognizer
{
    if (gestureRecognizer.state != UIGestureRecognizerStateEnded)
    {
        return;
    }
    
    CGPoint touchPoint = [gestureRecognizer locationInView:mapview];
    [self moveAnnotationToCoordinate:[mapview convertPoint:touchPoint toCoordinateFromView:mapview]];
}

#pragma mark AZDraggableAnnotationView delegate

- (void)movedAnnotation:(MKPointAnnotation *)anno
{
    NSLog(@"Dragged annotation to %f,%f", anno.coordinate.latitude, anno.coordinate.longitude);
    
    CLLocation *newLocation = [[CLLocation alloc] initWithLatitude:anno.coordinate.latitude longitude:anno.coordinate.longitude];
    
    [self.geoCoder reverseGeocodeLocation: newLocation completionHandler:
     ^(NSArray *placemarks, NSError *error) {
         
         //Get nearby address
         CLPlacemark *placemark = [placemarks objectAtIndex:0];
         
         //String to hold address
         NSString *locatedAt = [[placemark.addressDictionary valueForKey:@"FormattedAddressLines"] componentsJoinedByString:@", "];
         
         //Print the location to console
         NSLog(@"I am currently at %@",locatedAt);
         
         //Set the label text to current location
         searchField.text = locatedAt;
         
         double longitude = placemark.location.coordinate.longitude;
         double latitude = placemark.location.coordinate.latitude;
         
         NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
         [defaults setValue:placemark.thoroughfare forKey:@"workAdd1"];
         [defaults setValue:placemark.locality forKey:@"workCity"];
         [defaults setValue:placemark.administrativeArea forKey:@"workState"];
         [defaults setValue:placemark.postalCode forKey:@"workZip"];
         
         NSString *workLatLongStr = [NSString stringWithFormat:@"%f,%f",latitude,longitude];
         [defaults setValue:workLatLongStr forKey:@"worklatlong"];
         
     }];
}



- (void)locationManager:(CLLocationManager *)manager didUpdateLocations:(NSArray *)locations
{
        [self.geoCoder reverseGeocodeLocation:locationManager.location completionHandler:^(NSArray *placemarks, NSError *error)
            {
            CLPlacemark *placemark = [placemarks objectAtIndex:0];
            [locationManager stopUpdatingLocation];
            NSString *addressString = [NSString stringWithFormat:@"%@ %@,%@ %@,%@",placemark.subThoroughfare,placemark.thoroughfare,placemark.locality,placemark.postalCode,placemark.administrativeArea];
            [self searchCoordinatesForAddress:addressString];
            searchField.text = addressString;
        }];
}

- (void)locationManager:(CLLocationManager *)manager didFailWithError:(NSError *)error
{
    [self searchCoordinatesForAddress:@"100 Forest Ave,Palo Alto,94301 CA"];
    searchField.text = @"100 Forest Ave,Palo Alto,94301 CA";
}

- (void)textFieldDidEndEditing:(UITextField *)textField
{
    [self searchCoordinatesForAddress:searchField.text];
}

- (void)searchCoordinatesForAddress:(NSString *)inAddress
{
    //Build the string to Query Google Maps.
    NSMutableString *urlString = [NSMutableString stringWithFormat:@"http://maps.google.com/maps/geo?q=%@?output=json",inAddress];
    
    //Replace Spaces with a '+' character.
    [urlString setString:[urlString stringByReplacingOccurrencesOfString:@" " withString:@"+"]];
    
    //Create NSURL string from a formate URL string.
    NSURL *url = [NSURL URLWithString:urlString];
    
    //Setup and start an async download.
    
    //Note that we should test for reachability!.
    NSURLRequest *request = [[NSURLRequest alloc] initWithURL:url];
    NSData *response = [NSURLConnection sendSynchronousRequest:request returningResponse:nil error:nil];
     NSDictionary *json = [NSJSONSerialization JSONObjectWithData:response options:kNilOptions error:nil];
    
    NSArray *placemark  = [json objectForKey:@"Placemark"];
    NSArray *coordinates = [[placemark objectAtIndex:0] valueForKeyPath:@"Point.coordinates"];
   
    NSString *workAdd1 = [[placemark objectAtIndex:0] valueForKeyPath:@"AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.DependentLocality.Thoroughfare.ThoroughfareName"];
    NSString *workCity = [[placemark objectAtIndex:0] valueForKeyPath:@"AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.LocalityName"];
     NSString *workState = [[placemark objectAtIndex:0] valueForKeyPath:@"AddressDetails.Country.AdministrativeArea.AdministrativeAreaName"];
    NSString *zipCode = [[placemark objectAtIndex:0] valueForKeyPath:@"AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.DependentLocality.PostalCode.PostalCodeNumber"];
  
    
    double longitude = [[coordinates objectAtIndex:0] doubleValue];
    double latitude = [[coordinates objectAtIndex:1] doubleValue];
    
    NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
    [defaults setValue:workAdd1 forKey:@"workAdd1"];
    [defaults setValue:workCity forKey:@"workCity"];
    [defaults setValue:workState forKey:@"workState"];
    [defaults setValue:zipCode forKey:@"workZip"];
    
    NSString *workLatLongStr = [NSString stringWithFormat:@"%f,%f",latitude,longitude];
    [defaults setValue:workLatLongStr forKey:@"worklatlong"];
//    
   // [defaults synchronize];
    
    [self zoomMapAndCenterAtLatitude:latitude andLongitude:longitude];
}


- (void)connection:(NSURLConnection *)connection didReceiveData:(NSData *)data
{
    
}

- (void) zoomMapAndCenterAtLatitude:(double) latitude andLongitude:(double) longitude
{
    MKCoordinateRegion region;
    region.center.latitude  = latitude;
    region.center.longitude = longitude;
    
    //Set Zoom level using Span
    MKCoordinateSpan span;
    span.latitudeDelta  = .08;
    span.longitudeDelta = .08;
    region.span = span;
    
    //Move the map and zoom
    [mapview setRegion:region animated:YES];
    
    //Add annotation
    
  //  CLLocationCoordinate2D coord =  {.latitude = latitude,.longitude = longitude};
    
    movableCoordinates.latitude = latitude;
    movableCoordinates.longitude = longitude;
    [self moveAnnotationToCoordinate:movableCoordinates];
    
}

- (void)touchesEnded:(NSSet *)touches withEvent:(UIEvent *)event
{
    if ([searchField isFirstResponder])
    {
        [searchField resignFirstResponder];
    }
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
