//
//  RZUser.h
//  Rizedu
//
//  Created by Tao Xie on 10/7/12.
//  Copyright (c) 2012 Tao Xie. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface RZUser : NSObject

@property (nonatomic, retain) NSString *fbId;
@property (nonatomic, retain) NSString *firstName;
@property (nonatomic, retain) NSString *lastName;
@property (nonatomic, retain) NSString *email;
@property (nonatomic, retain) NSString *homeAddr;
@property (nonatomic, retain) NSString *homeCity;
@property (nonatomic, retain) NSString *homeState;
@property (nonatomic, retain) NSString *homeZipCode;
@property (nonatomic, retain) NSString *workAddr;
@property (nonatomic, retain) NSString *workCity;
@property (nonatomic, retain) NSString *workState;
@property (nonatomic, retain) NSString *workZipCode;

@property (nonatomic, retain) NSString *homeLatitude;
@property (nonatomic, retain) NSString *homeLongitude;
@property (nonatomic, retain) NSString *workLatitude;
@property (nonatomic, retain) NSString *workLongitude;

@end
