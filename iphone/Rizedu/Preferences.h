//
//  Preferences.h
//  Rizedu
//
//  Created by Tao Xie on 10/7/12.
//  Copyright (c) 2012 Tao Xie. All rights reserved.
//

#import <Foundation/Foundation.h>
#import <CoreData/CoreData.h>


@interface Preferences : NSManagedObject

@property (nonatomic, retain) NSString * key;
@property (nonatomic, retain) NSString * value;
@property (nonatomic, retain) NSString * defaultValue;

@end
