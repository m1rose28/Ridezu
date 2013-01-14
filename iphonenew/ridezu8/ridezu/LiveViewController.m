//
//  LiveViewController.m
//  ridezu
//
//  Created by Vikram Chowdary on 23/12/12.
//  Copyright (c) 2012 Vikram Chowdary. All rights reserved.
//

#import "LiveViewController.h"

@interface LiveViewController ()

@end

@implementation LiveViewController

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
    
    searchField.delegate = self;
    mapview.delegate = self;
    
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

- (void)moveAnnotationToCoordinate:(CLLocationCoordinate2D)coordinate
{
    if (annotation) {
        [UIView beginAnimations:[NSString stringWithFormat:@"slideannotation%@", annotation] context:nil];
        [UIView setAnimationCurve:UIViewAnimationCurveEaseOut];
        [UIView setAnimationDuration:0.2];
        
        annotation.coordinate = coordinate;
        
        [self movedAnnotation:annotation];
        
        [UIView commitAnimations];
    } else {
        annotation = [[MKPointAnnotation alloc] init];
        annotation.coordinate = movablecoordinates;
        
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
         [defaults setValue:placemark.thoroughfare forKey:@"homeAdd1"];
         [defaults setValue:placemark.locality forKey:@"homeCity"];
         [defaults setValue:placemark.administrativeArea forKey:@"homeState"];
         [defaults setValue:placemark.postalCode forKey:@"homeZip"];
         
         NSString *homeLatLongStr = [NSString stringWithFormat:@"%f,%f",latitude,longitude];
         
         [defaults setValue:homeLatLongStr forKey:@"homelatlong"];
         
     }];
}


- (void)locationManager:(CLLocationManager *)manager didUpdateLocations:(NSArray *)locations
{
    [self.geoCoder reverseGeocodeLocation:locationManager.location completionHandler:^(NSArray *placemarks, NSError *error) {
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

- (void)searchBarSearchButtonClicked:(UITextField *)searchBar
{
    [self searchCoordinatesForAddress:[searchBar text]];
    
    //Hide the keyboard.
    [searchBar resignFirstResponder];
}

- (BOOL)textFieldShouldReturn:(UITextField *)textField
{
    [textField resignFirstResponder];
    [self searchCoordinatesForAddress:searchField.text];
    
    return YES;
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
    
    double longitude = [[coordinates objectAtIndex:0] doubleValue];
    double latitude = [[coordinates objectAtIndex:1] doubleValue];
    
    NSString *homeAdd1 = [[placemark objectAtIndex:0] valueForKeyPath:@"AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.DependentLocality.Thoroughfare.ThoroughfareName"];
    NSString *homeCity = [[placemark objectAtIndex:0] valueForKeyPath:@"AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.LocalityName"];
    NSString *homeState = [[placemark objectAtIndex:0] valueForKeyPath:@"AddressDetails.Country.AdministrativeArea.AdministrativeAreaName"];
    NSString *homeZipCode = [[placemark objectAtIndex:0] valueForKeyPath:@"AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.DependentLocality.PostalCode.PostalCodeNumber"];
    
    NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
    [defaults setValue:homeAdd1 forKey:@"homeAdd1"];
    [defaults setValue:homeCity forKey:@"homeCity"];
    [defaults setValue:homeState forKey:@"homeState"];
    [defaults setValue:homeZipCode forKey:@"homeZip"];
    
    NSString *homeLatLongStr = [NSString stringWithFormat:@"%f,%f",latitude,longitude];
    
    [defaults setValue:homeLatLongStr forKey:@"homelatlong"];
    
    [self zoomMapAndCenterAtLatitude:latitude andLongitude:longitude];
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
    
    movablecoordinates.latitude = latitude;
    movablecoordinates.longitude = longitude;
    [self moveAnnotationToCoordinate:movablecoordinates];

}

- (IBAction)next:(id)sender
{
    NSArray *keys = [NSArray arrayWithObjects:@"fbid",@"fname",@"lname", @"add1",@"city",@"state",@"zip",@"workadd1",@"workcity",@"workstate",@"workzip",@"email",@"homelatlong",@"worklatlong",@"profileblob",@"timezone",@"preference",@"leavetime",@"hometime",@"notificationmethod",@"ridereminders", nil];

    NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
    
    NSArray *objects = [NSArray arrayWithObjects:[defaults valueForKey:@"fbid"],
                            [defaults valueForKey:@"fname"],
                            [defaults valueForKey:@"lname"],
                            [defaults valueForKey:@"homeAdd1"],
                            [defaults valueForKey:@"homeCity"],
                            [defaults valueForKey:@"homeState"],
                            [defaults valueForKey:@"homeZip"],
                            [defaults valueForKey:@"workAdd1"],
                            [defaults valueForKey:@"workCity"],
                            [defaults valueForKey:@"workState"],
                            [defaults valueForKey:@"workZip"],
                            [defaults valueForKey:@"email"],
                            [defaults objectForKey:@"homelatlong"],
                            [defaults objectForKey:@"worklatlong"],
                            [defaults objectForKey:@"profileBlob"],
                            @"PDT",
                            @"EMAIL",
                            @"09:00:00",
                            @"17:00:00",
                            @"EMAIL",
                            @"1",nil];
    
    NSDictionary *jsonDict = [NSDictionary dictionaryWithObjects:objects forKeys:keys];
    
    //convert object to data
    NSError *error;
    NSData* jsonData = [NSJSONSerialization dataWithJSONObject:jsonDict
                                                       options:NSJSONWritingPrettyPrinted
                                                         error:&error];
 //   NSString *str = [[NSString alloc] initWithData:jsonData encoding:NSUTF8StringEncoding];
    
    NSLog(@"%@",[error description]);
    
    NSURL *url = [NSURL URLWithString:@"https://stage.ridezu.com/ridezu/api/v/1/users"];
    
    NSMutableURLRequest *request = [NSMutableURLRequest requestWithURL:url
                                                           cachePolicy:NSURLRequestUseProtocolCachePolicy timeoutInterval:60.0];
    
    
   // NSData *requestData = [NSData dataWithBytes:[jsonRequest UTF8String] length:[jsonRequest length]];
    
    [request setHTTPMethod:@"POST"];
    [request setValue:[defaults valueForKey:@"fbid"] forHTTPHeaderField:@"X-Id"];
    [request setValue:@"application/json" forHTTPHeaderField:@"Content-Type"];
    [request setValue:[NSString stringWithFormat:@"%d", [jsonData length]] forHTTPHeaderField:@"Content-Length"];
    [request setHTTPBody:jsonData];
    
    NSURLConnection *connection = [[NSURLConnection alloc]initWithRequest:request delegate:self];
    [connection start];
}

- (void)connection:(NSURLConnection *)connection didFailWithError:(NSError *)error
{
    NSLog(@"%@",[error description]);
}

- (void)connection:(NSURLConnection *)connection didReceiveData:(NSData *)data
{
   // NSString *jsonString = [[NSString alloc] initWithData:data encoding:NSUTF8StringEncoding];
    
 //   NSData *tempData = [jsonString dataUsingEncoding:NSUTF8StringEncoding];
    
    NSDictionary *tempDict = [NSJSONSerialization JSONObjectWithData:data options:kNilOptions error:nil];
    
    NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
    [defaults setValue:[tempDict valueForKey:@"seckey"] forKey:@"secretKey"];
    
    [defaults synchronize];
    
    [self loadWebController];
}

- (BOOL)connection:(NSURLConnection *)connection canAuthenticateAgainstProtectionSpace:(NSURLProtectionSpace *)protectionSpace
{
    return [protectionSpace.authenticationMethod isEqualToString:NSURLAuthenticationMethodServerTrust];
}

- (void)connection:(NSURLConnection *)connection didReceiveAuthenticationChallenge:(NSURLAuthenticationChallenge *)challenge
{
    [challenge.sender useCredential:[NSURLCredential credentialForTrust:challenge.protectionSpace.serverTrust] forAuthenticationChallenge:challenge];
    
    [challenge.sender continueWithoutCredentialForAuthenticationChallenge:challenge];
}

- (void)loadWebController
{
    AppDelegate *appDelegate = (AppDelegate *)[[UIApplication sharedApplication] delegate];
    
    [appDelegate setupNavigationControllerApp];
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
