//
//  RZGlobalService.h
//  Rizedu
//
//  Created by Tao Xie on 10/16/12.
//  Copyright (c) 2012 Tao Xie. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface RZGlobalService : NSObject {
    
}
@property (nonatomic, strong) MKNetworkEngine *ridezuEngine;
+ (RZGlobalService *)singleton;
+ (NSArray*)shortTimeTable;
+ (NSArray*)fullTimeTable;
@end
