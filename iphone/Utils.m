//
//  Utils.m
//  Flash2Pay
//
//  Created by Tao Xie on 4/23/12.
//  Copyright (c) 2012 Trilleum Interactives. All rights reserved.
//
#import "Constants.h"
#import "Utils.h"

@implementation Utils

+ (NSDictionary*)cardTypeInfo:(int)index {
    NSArray* cardTypes = @[@"VISA", @"MasterCard", @"American Express", @"Discover Card", @"Diners Club", @"UnionPay"];
    NSArray* cardLogos = @[@"visa", @"mastercard", @"amex", @"discover", @"dinersclub", @"unionpay"];
    
    NSDictionary *dict = @{
        @"cardType" : [cardTypes objectAtIndex:index],
        @"cardLogo" : [cardLogos objectAtIndex:index]};
    return dict;
}

+(NSString*)appVersion { 
    return [[NSBundle mainBundle] objectForInfoDictionaryKey:@"CFBundleShortVersionString"];
}

+(NSString*)appBuildNumber {
    return [[NSBundle mainBundle] objectForInfoDictionaryKey:@"CFBundleVersion"];
}

+ (NSString*)cleanString:(NSString*)str {
    return [str stringByTrimmingCharactersInSet:[NSCharacterSet newlineCharacterSet]];
}

+ (void)initDirectories {
    [Utils createDirectory:kMediasFolder];
    [Utils createDirectory:kSnapshotsFolder];
}

+ (NSString*)createDirectory:(NSString*)dirName {
    NSString *documentsDirectory = [NSSearchPathForDirectoriesInDomains(NSDocumentDirectory, NSUserDomainMask, YES) objectAtIndex:0];
    NSString *newDirectory = [NSString stringWithFormat:@"%@/%@", documentsDirectory, dirName];
    
    if (![[NSFileManager defaultManager] fileExistsAtPath:newDirectory]) {
        // Directory does not exist so create it
        [[NSFileManager defaultManager] createDirectoryAtPath:newDirectory withIntermediateDirectories:YES attributes:@{NSFileProtectionKey : NSFileProtectionComplete} error:nil];
        return newDirectory;
    }
    return nil;
}

+ (NSString*)createDirectory:(NSString*)dirName inFolder:(NSString*)folderName {
    return [Utils createDirectory:[NSString stringWithFormat:@"%@/%@", folderName, dirName]];
}

+ (NSArray*)listDirectory:(NSString*)dirName {
    NSString *documentsDirectory = [NSSearchPathForDirectoriesInDomains(NSDocumentDirectory, NSUserDomainMask, YES) objectAtIndex:0];
    NSString *dirPath = [NSString stringWithFormat:@"%@/%@", documentsDirectory, dirName];
    
    if ([[NSFileManager defaultManager] fileExistsAtPath:dirPath]) {
        NSError *dataError = nil;
        NSArray* files = [[NSFileManager defaultManager] contentsOfDirectoryAtPath:dirPath error:&dataError];
        DLog(@"files: %@", files);
        return files;
    }
    else {
        return nil;
    }
}
+ (NSString*)getImagePath:(NSString*)imageName {
    NSString *documentsDirectory = [NSSearchPathForDirectoriesInDomains(NSDocumentDirectory, NSUserDomainMask, YES) objectAtIndex:0];
    NSString *imagePath = [NSString stringWithFormat:@"%@/%@/%@", documentsDirectory, kMediasFolder, imageName];
    DLog(@"imagePath:%@", imagePath);
    return imagePath;
}

+ (UIImage*)getImage:(NSString*)imageName {
    UIImage *image = [UIImage imageWithContentsOfFile:[Utils getImagePath:imageName]];
    return image;
}
+ (void)saveImage:(UIImage*)image asName:(NSString*)imageName {
    NSString *documentsDirectory = [NSSearchPathForDirectoriesInDomains(NSDocumentDirectory, NSUserDomainMask, YES) objectAtIndex:0];
    NSString *imagePath = [NSString stringWithFormat:@"%@/%@/%@", documentsDirectory, kMediasFolder, imageName];
    [UIImagePNGRepresentation(image) writeToFile:imagePath atomically:YES];
}

+ (NSArray*)listAlbums {
    return [Utils listDirectory:kMediasFolder];
}

+ (NSArray*)listAlbum:(NSString*)albumName {
    return [Utils listDirectory:[NSString stringWithFormat:@"%@/%@", kMediasFolder, albumName]];
}

+ (NSString*)getSnapshotPath:(NSString*)imageName {
    NSString *documentsDirectory = [NSSearchPathForDirectoriesInDomains(NSDocumentDirectory, NSUserDomainMask, YES) objectAtIndex:0];
    NSString *imagePath = [NSString stringWithFormat:@"%@/%@/%@", documentsDirectory, kSnapshotsFolder, imageName];
    DLog(@"snapshotPath:%@", imagePath);
    return imagePath;
}

+ (UIImage*)getSnapshot:(NSString*)imageName {
    UIImage *snapshot = [UIImage imageWithContentsOfFile:[Utils getSnapshotPath:imageName]];
    return snapshot;
}

+ (void)saveSnapshot:(UIImage*)image asName:(NSString*)imageName {
    NSString *documentsDirectory = [NSSearchPathForDirectoriesInDomains(NSDocumentDirectory, NSUserDomainMask, YES) objectAtIndex:0];
    NSString *imagePath = [NSString stringWithFormat:@"%@/%@/%@", documentsDirectory, kSnapshotsFolder, imageName];
    [UIImageJPEGRepresentation(image, 1.0) writeToFile:imagePath atomically:YES];
}

+ (NSString *)genUUID{
    CFUUIDRef theUUID = CFUUIDCreate(NULL);
    CFStringRef uuidStr = CFUUIDCreateString(NULL, theUUID);
    CFRelease(theUUID);
    return (__bridge NSString *)uuidStr;
}

+ (NSMutableArray*)load:(NSString*)fileName {
    NSString *documentsDirectory = [NSSearchPathForDirectoriesInDomains(NSDocumentDirectory, NSUserDomainMask, YES) objectAtIndex:0];
    NSString *albumPath = [documentsDirectory stringByAppendingPathComponent:fileName];
	
    DLog(@"album path:%@", albumPath);
    if ([[NSFileManager defaultManager] fileExistsAtPath:albumPath]){
		return [NSMutableArray arrayWithContentsOfFile: albumPath];
	} else {
		return nil;
    }
}

+ (void)save:(NSMutableArray*)data toFile:(NSString*)fileName {
	NSString *documentsDirectory = [NSSearchPathForDirectoriesInDomains(NSDocumentDirectory, NSUserDomainMask, YES) objectAtIndex:0];
    NSString *plistPath = [documentsDirectory stringByAppendingPathComponent:fileName];
    DLog(@"~~~~~~~ Utils.save: data:%@", data);
    DLog(@"[INFO] PLIST: Document %@ was written to disk!", fileName);
	[data writeToFile:plistPath atomically:YES];
}

+ (NSMutableDictionary*)loadSettings {
    NSString *documentsDirectory = [NSSearchPathForDirectoriesInDomains(NSDocumentDirectory, NSUserDomainMask, YES) objectAtIndex:0];
    NSString *plistPath = [documentsDirectory stringByAppendingPathComponent:settingsFileName];
    DLog(@"plistPath:%@", plistPath);
    if ([[NSFileManager defaultManager] fileExistsAtPath:plistPath]){
        return [NSMutableDictionary dictionaryWithContentsOfFile:plistPath];
    } else {
        // Default values for miscellenous settings
        NSMutableDictionary *settings = [NSMutableDictionary dictionaryWithObjectsAndKeys:
                                         nil, kAccountId, nil];
        
        // [Utils saveSettings:settings];
        return settings;
    }
    
}

+ (void)saveSettings:(NSMutableDictionary*)settings {
    
    // [Utils save:settings toFile:settingsFileName];
    NSString *documentsDirectory = [NSSearchPathForDirectoriesInDomains(NSDocumentDirectory, NSUserDomainMask, YES) objectAtIndex:0];
    NSString *plistPath = [documentsDirectory stringByAppendingPathComponent:settingsFileName];
    DLog(@"Utils.save: data:%@", settings);
	[settings writeToFile:plistPath atomically:YES];
	DLog(@"[INFO] PLIST: Document %@ was written to disk!", settingsFileName); 
}

+ (NSString*)friendlyLastUpdateDate:(NSDate*)lastUpdateDate {
    NSCalendar* calendar = [NSCalendar currentCalendar];
    NSDate *now = [NSDate date];
    NSDate *yesterday = [NSDate dateWithTimeIntervalSinceNow:-86400];
        
    unsigned unitFlags = NSYearCalendarUnit | NSMonthCalendarUnit | NSDayCalendarUnit | NSHourCalendarUnit | NSMinuteCalendarUnit;
    
    NSDateComponents *currDateComponents = [calendar components:unitFlags fromDate:now];
    NSInteger currYear = [currDateComponents year];
    NSInteger currMonth = [currDateComponents month];
    NSInteger currDay = [currDateComponents day];
    
    NSDateComponents *callingDateComponents = [calendar components:unitFlags fromDate:lastUpdateDate];
    NSInteger callingYear = [callingDateComponents year];
    NSInteger callingMonth = [callingDateComponents month];
    NSInteger callingDay = [callingDateComponents day];
    
    if ((currYear == callingYear) && (currMonth == callingMonth) && (currDay == callingDay)) {
        // Today
        NSDateFormatter *format = [[NSDateFormatter alloc] init];
        [format setDateFormat:@"HH:mm"];
        return [format stringFromDate:lastUpdateDate];
    }
    else if (lastUpdateDate > yesterday) {
        return @"Yesterday";        
    }
    else {
        NSDateFormatter *format = [[NSDateFormatter alloc] init];
        [format setDateFormat:@"MMM dd"];
        return [format stringFromDate:lastUpdateDate];
    }
}

+ (NSString*)normalizeFullName:(NSString*)_firstName lastName:(NSString*)_lastName {
    if (_firstName == nil) {
        return _lastName;
    }
    else if (_lastName == nil) {
        return _firstName;
    }
    else {
        return [NSString stringWithFormat:@"%@ %@", _firstName, _lastName];
    }
}

+ (NSString*)ageRange:(NSString*)birthDateString {
    NSDateFormatter *format = [[NSDateFormatter alloc] init];
    [format setDateFormat:@"MM/dd/yyyy"];
    NSDate *birthDate = [format dateFromString:birthDateString];
    NSDate *now = [NSDate date];
    NSCalendar* calendar = [NSCalendar currentCalendar];
    NSDateComponents* birthCompnents = [calendar components:NSYearCalendarUnit|NSMonthCalendarUnit|NSDayCalendarUnit fromDate:birthDate];
    NSDateComponents* nowCompnents = [calendar components:NSYearCalendarUnit|NSMonthCalendarUnit|NSDayCalendarUnit fromDate:now];

    int age = [nowCompnents year] - [birthCompnents year] ;
    if (age < 18) {
        return @"less than 18";
    }
    else if (age >= 18 && age < 25) {
        return @"18 - 24";
    }
    else if (age >= 25 && age < 35) {
        return @"25 - 34";
    }
    else if (age >= 35 && age < 45) {
        return @"35 - 44";
    }
    else {
        return @"45+";
    }
}

@end
