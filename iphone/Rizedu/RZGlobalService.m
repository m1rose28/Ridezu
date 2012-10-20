//
//  RZGlobalService.m
//  Rizedu
//
//  Created by Tao Xie on 10/16/12.
//  Copyright (c) 2012 Tao Xie. All rights reserved.
//

#import "RZGlobalService.h"

@implementation RZGlobalService
+ (RZGlobalService *)singleton {
    static RZGlobalService *_instance;
    if (nil == _instance) {
        @synchronized (self) {
            _instance = [[RZGlobalService alloc] init];
            _instance.ridezuEngine = [[MKNetworkEngine alloc] initWithHostName:@"ec2-50-18-0-33.us-west-1.compute.amazonaws.com" customHeaderFields:nil];
        }
    }
    return _instance;
}

+ (NSArray*)timeTable {
     NSArray *timeTable = @[@"5:30am", @"6:00am", @"6:30am", @"7:00am", @"7:30am", @"8:00am", @"8:30am", @"9:00am", @"9:30am"];
    return timeTable;
}

//+ (NSArray*)autofill:(NSArray*)times {
//    if ([times count] >= 4)
//        return nil;
//    
//    for (NSString* time in times) {
//        NSUInteger index = [[RZGlobalService timeTable] indexOfObject:time];
//    }
//    [RZGlobalService timeTable]
//}
@end
