//
//  RZUser.m
//  Rizedu
//
//  Created by Tao Xie on 10/7/12.
//  Copyright (c) 2012 Tao Xie. All rights reserved.
//

#import "RZUser.h"

@implementation RZUser

- (NSMutableDictionary*)toRidezuDict {
    NSMutableDictionary *dict = [NSMutableDictionary dictionary];
    [dict setObject:self.fbId forKey:@"fbid"];
    [dict setObject:self.email forKey:@"email"];
    [dict setObject:self.firstName forKey:@"fname"];
    [dict setObject:self.lastName forKey:@"lname"];
    
    [dict setObject:self.homeAddr forKey:@"add1"];
    [dict setObject:self.homeCity forKey:@"city"];
    [dict setObject:self.homeState forKey:@"state"];
    [dict setObject:self.homeZipCode forKey:@"zip"];
    
    [dict setObject:self.workAddr forKey:@"workadd1"];
    [dict setObject:self.workCity forKey:@"workcity"];
    [dict setObject:self.workState forKey:@"workstate"];
    [dict setObject:self.workZipCode forKey:@"workzip"];
    
    [dict setObject:[NSString stringWithFormat:@"%@,%@", self.homeLatitude, self.homeLongitude] forKey:@"homelatlong"];
    [dict setObject:[NSString stringWithFormat:@"%@,%@", self.workLatitude, self.workLongitude] forKey:@"worklatlong"];
    
    [dict setObject:[NSString stringWithFormat:@"%@,%@", self.homeLatitude, self.homeLongitude] forKey:@"originlatlong"];
    [dict setObject:[NSString stringWithFormat:@"%@,%@", self.workLatitude, self.workLongitude] forKey:@"destlatlong"];
    
    return dict;
}
@end
