//
//  Utils.h
//  Flash2Pay
//
//  Created by Tao Xie on 4/23/12.
//  Copyright (c) 2012 Trilleum Interactives. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "Constants.h"

@interface Utils : NSObject

+ (NSString*)appVersion;
+ (NSString*)appBuildNumber;
+ (NSString*)cleanString:(NSString*)str;

+ (void)initDirectories;
+ (NSString*)createDirectory:(NSString*)dirName;
+ (NSString*)createDirectory:(NSString*)dirName inFolder:(NSString*)folderName;
+ (NSArray*)listDirectory:(NSString*)dirName;
+ (NSArray*)listAlbums;
+ (NSArray*)listAlbum:(NSString*)albumName; 

// album images
+ (UIImage*)getImage:(NSString*)imageName;
+ (NSString*)getImagePath:(NSString*)imageName;

+ (void)saveImage:(UIImage*)image asName:(NSString*)imageName;

// snapshot for failed login attempt
+ (NSString*)getSnapshotPath:(NSString*)imageName;
+ (UIImage*)getSnapshot:(NSString*)imageName;
+ (void)saveSnapshot:(UIImage*)image asName:(NSString*)imageName;

+ (NSString *)genUUID;
+ (NSDictionary*)cardTypeInfo:(int)index;

+ (NSMutableDictionary*)loadSettings;
+ (void)saveSettings:(NSMutableDictionary *)settings;

+ (NSString*)friendlyLastUpdateDate:(NSDate*)lastUpdateDate;
+ (NSString*)normalizeFullName:(NSString*)_firstName lastName:(NSString*)_lastName;

+ (NSString*)ageRange:(NSString*)birthDateString;
@end
