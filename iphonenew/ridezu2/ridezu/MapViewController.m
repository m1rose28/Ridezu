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

- (void)viewDidAppear:(BOOL)animated
{
    [super viewDidAppear:animated];
}

- (void)locationManager:(CLLocationManager *)manager didUpdateToLocation:(CLLocation *)newLocation fromLocation:(CLLocation *)oldLocation
{
    
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
    
   // NSArray *worklatLong = [[NSArray alloc] initWithObjects:[coordinates objectAtIndex:0],[coordinates objectAtIndex:1], nil];
   // NSDictionary *worklatlongDict = [NSDictionary dictionaryWithObject:latLong forKey:@"worklatlong"];
    
    NSString *workLatLongStr = [NSString stringWithFormat:@"%f,%f",latitude,longitude];
    [defaults setValue:workLatLongStr forKey:@"worklatlong"];
//    
   // [defaults synchronize];
    
    [self zoomMapAndCenterAtLatitude:latitude andLongitude:longitude];
}


- (void)connection:(NSURLConnection *)connection didReceiveData:(NSData *)data
{
    //The string received from google's servers
  //  NSData *jsonData = [jsonString dataUsingEncoding:NSASCIIStringEncoding];
   
    //JSON Framework magic to obtain a dictionary from the jsonString.
 //   NSDictionary *results = [jsonString JSONValue];
    
    //Now we need to obtain our coordinates
 //   NSArray *placemark  = [results objectForKey:@"Placemark"];
  //  NSArray *coordinates = [[placemark objectAtIndex:0] valueForKeyPath:@"Point.coordinates"];
    
    //I put my coordinates in my array.
  //  double longitude = [[coordinates objectAtIndex:0] doubleValue];
  //  double latitude = [[coordinates objectAtIndex:1] doubleValue];
    
    //Debug.
    //NSLog(@"Latitude - Longitude: %f %f", latitude, longitude);
    
    //I zoom my map to the area in question.
   // [self zoomMapAndCenterAtLatitude:latitude andLongitude:longitude];
    
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
        annotationView.image = [UIImage imageNamed:@"work"];
        
        UIImageView *overlayImage = [[UIImageView alloc] initWithImage:[UIImage imageNamed:@"circle"]];
        
        overlayImage.frame = CGRectMake(0, 0, 60, 60);
        
        overlayImage.center = CGPointMake(annotationView.center.x+20, annotationView.center.y+20);
        
        [annotationView addSubview:overlayImage];
        
        return annotationView;
    }
    return 0;
}
- (void)touchesEnded:(NSSet *)touches withEvent:(UIEvent *)event
{
    if ([searchbar isFirstResponder])
    {
        [searchbar resignFirstResponder];
    }
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
