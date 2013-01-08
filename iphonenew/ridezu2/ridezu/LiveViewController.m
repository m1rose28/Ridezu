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
@synthesize searchbar;
@synthesize mapview;

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
}

- (void)locationManager:(CLLocationManager *)manager didUpdateLocations:(NSArray *)locations
{
    [self.geoCoder reverseGeocodeLocation:locationManager.location completionHandler:^(NSArray *placemarks, NSError *error) {
        CLPlacemark *placemark = [placemarks objectAtIndex:0];
        [locationManager stopUpdatingLocation];
        NSString *addressString = [NSString stringWithFormat:@"%@ %@,%@ %@,%@",placemark.subThoroughfare,placemark.thoroughfare,placemark.locality,placemark.postalCode,placemark.administrativeArea];
        [self searchCoordinatesForAddress:addressString];
        searchbar.text = addressString;

    }];
}

- (void)locationManager:(CLLocationManager *)manager didFailWithError:(NSError *)error
{
    [self searchCoordinatesForAddress:@"100 Forest Ave,Palo Alto,94301 CA"];
    searchbar.text = @"100 Forest Ave,Palo Alto,94301 CA";
}

- (void)searchBarSearchButtonClicked:(UISearchBar *)searchBar
{
    [self searchCoordinatesForAddress:[searchBar text]];
    
    //Hide the keyboard.
    [searchBar resignFirstResponder];
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
    
   // NSArray *homelatLong = [[NSArray alloc] initWithObjects:[coordinates objectAtIndex:0],[coordinates objectAtIndex:1], nil];
    
  //  NSDictionary *worklatlongDict = [NSDictionary dictionaryWithObject:latLong forKey:@"homelatlong"];
    
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
    
    CLLocationCoordinate2D coord =  {.latitude = latitude,.longitude = longitude};
    
    MapAnnotation *mapAnnotation = [[MapAnnotation alloc] initwithCordinates:coord placeName:@"Place" description:@"Description"];
    
    [mapview addAnnotation:mapAnnotation];
}

- (MKAnnotationView *)mapView:(MKMapView *)mapView viewForAnnotation:(id<MKAnnotation>)annotation
{
    static NSString *identifier = @"MyLocation";
    if ([annotation isKindOfClass:[MapAnnotation class]])
    {
        MKPinAnnotationView *annotationView = (MKPinAnnotationView *)[mapView dequeueReusableAnnotationViewWithIdentifier:identifier];
        if (annotationView == nil)
        {
            annotationView = [[MKPinAnnotationView alloc] initWithAnnotation:annotation reuseIdentifier:identifier];
        }
        else
        {
            annotationView.annotation = annotation;
        }
        annotationView.animatesDrop = NO;
        annotationView.enabled = YES;
        annotationView.canShowCallout = YES;
        annotationView.image = [UIImage imageNamed:@"home"];
        
        UIImageView *overlayImage = [[UIImageView alloc] initWithImage:[UIImage imageNamed:@"circle"]];
        
        overlayImage.frame = CGRectMake(0, 0, 60, 60);
        
        overlayImage.center = CGPointMake(annotationView.center.x+20, annotationView.center.y+20);
        
        [annotationView addSubview:overlayImage];
        
        return annotationView;
    }
    return 0;
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
   // [request setValue:@"application/json" forHTTPHeaderField:@"Accept"];
    [request setValue:[defaults valueForKey:@"fbid"] forHTTPHeaderField:@"X-Id"];
   // [request setValue:@"" forHTTPHeaderField:@"X-Signature"];
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
    
    if (![[tempDict valueForKey:@"seckey"] isEqual:NULL])
    {
        [defaults setBool:YES forKey:@"Sucess"];
    }
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

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
