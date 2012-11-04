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
            _instance.ridezuEngine = [[MKNetworkEngine alloc] initWithHostName:RIDEZU_HOSTNAME customHeaderFields:nil];
        }
    }
    return _instance;
}

+ (NSArray*)shortTimeTable {
     NSArray *timeTable = @[@"7:00am", @"7:30am", @"8:00am", @"8:30am", @"9:00am"];
    return timeTable;
}

+ (NSArray*)fullTimeTable {
    NSArray *timeTable = @[
    @"5:00am", @"5:30am",
    @"6:00am", @"6:30am",
    @"7:00am", @"7:30am",
    @"8:00am", @"8:30am",
    @"9:00am", @"9:30am",
    @"10:00am", @"10:30am",
    @"11:00am", @"11:30am",
    @"12:00pm", @"12:30pm",
    @"1:00pm", @"1:30pm",
    @"2:00pm", @"2:30pm",
    @"3:00pm", @"3:30pm",
    @"4:00pm", @"4:30pm",
    @"5:00pm", @"5:30pm",
    @"6:00pm", @"6:30pm",
    @"7:00pm", @"7:30pm",
    @"8:00pm", @"8:30pm",
    @"9:00pm", @"9:30pm",
    @"10:00pm", @"Show Less"
    ];
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

+ (UIColor*)greenColor {
    return [UIColor colorWithRed:69/255.f green:130/255.f blue:0/255.f alpha:1];
}
+ (UIColor*)lightGreenColor {
    return [UIColor colorWithRed:0/255.f green:205/255.f blue:0/255.f alpha:1];
}

// eventtime = "2012-10-23 09:30:00";
+ (NSString*)getTime:(NSString*)eventTime {
    NSDateFormatter *inputDateFormatter = [[NSDateFormatter alloc] init];
    [inputDateFormatter setDateFormat:@"yyyy-MM-dd hh:mm:ss"];
    
    NSDate *_eventTime = [inputDateFormatter dateFromString:eventTime];
    
    NSDateFormatter *outputDateFormatter = [[NSDateFormatter alloc] init];
    [outputDateFormatter setDateFormat:@"HH:mm"];
    return [outputDateFormatter stringFromDate:_eventTime];
}

+ (NSString*)getDateTime:(NSString*)time {
    NSDate *today = [NSDate date];
    NSDate *tomorrow = [NSDate dateWithTimeInterval:(24*60*60) sinceDate:[NSDate date]];
    NSDateFormatter *formatter = [[NSDateFormatter alloc] init];
    [formatter setDateFormat:@"yyyy-MM-dd"];
    
    NSDateFormatter *_formatter = [[NSDateFormatter alloc] init];
    [_formatter setDateFormat:@"yyyy-MM-dd hh:mma"];
    NSString* tmpStr = [NSString stringWithFormat:@"%@ %@", [formatter stringFromDate:tomorrow], time];
    NSDate *newDate = [_formatter dateFromString:tmpStr];
    
    NSDateFormatter *_newFormatter = [[NSDateFormatter alloc] init];
    [_newFormatter setDateFormat:@"yyyy-MM-dd HH:mm"];
    return [_newFormatter stringFromDate:newDate];
}


@end
