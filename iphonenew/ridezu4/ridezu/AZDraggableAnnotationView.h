//
//  AZDraggableAnnotationView.h
//  ridezu
//
//  Created by Vikram Chowdary on 13/01/13.
//  Copyright (c) 2013 Vikram Chowdary. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <MapKit/MapKit.h>

@protocol AZDraggableAnnotationViewDelegate <NSObject>
@required
- (void)movedAnnotation:(MKPointAnnotation *)annotation;
@end

@interface AZDraggableAnnotationView : MKAnnotationView {
    /**
     A flag to indicate whether this annotation is in the middle of being dragged
     */
    BOOL isMoving;
    
    /**
     The horizontal distance in pixels from the center of the annotation to the point
     at which the user touched and held the annotation. This annotation has a large
     'handle' so that it can be dragged without the center being obscured by the user's
     finger.
     */
    float touchXOffset;
    
    /**
     The vertical distance in pixels from the center of the annotation to the point
     at which the user touched and held the annotation. This annotation has a large
     'handle' so that it can be dragged without the center being obscured by the user's
     finger.
     */
    float touchYOffset;
}

/**
 A delegate that to receive events
 */
@property (nonatomic, strong) id <AZDraggableAnnotationViewDelegate> delegate;

/**
 A reference to the MKMapView to which this annotation has been added
 */
@property (nonatomic, strong) MKMapView *mapView;

@end
