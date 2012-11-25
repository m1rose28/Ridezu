//
//  RZGlobalService.h
//  Rizedu
//
//  Created by Tao Xie on 10/16/12.
//  Copyright (c) 2012 Tao Xie. All rights reserved.
//

#import <Foundation/Foundation.h>
#import <UIKit/UIKit.h>

#define RIDEZU_HOSTNAME @"www.ridezu.com"

@interface RZGlobalService : NSObject {
    
}
@property (nonatomic, strong) MKNetworkEngine *ridezuEngine;
+ (RZGlobalService *)singleton;
+ (NSArray*)shortTimeTable;
+ (NSArray*)fullTimeTable;

+ (UIColor*)greenColor;
+ (UIColor*)lightGreenColor;
+ (UIColor*)buttonGreenColor;

+ (NSString*)getTime:(NSString*)eventTime;

+ (NSString*)getDateTime:(NSString*)time;

+ (UIImage*)grabberImage;
+ (UIBarButtonItem*)grabberBarButtonItem:(id)target;

+ (NSString*)activeUserId;
+ (NSString*)activeUserName;
@end
