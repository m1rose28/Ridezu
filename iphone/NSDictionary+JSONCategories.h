//
//  NSDictionary+JSONCategories.h
//  Rizedu
//
//  Created by Tao Xie on 10/5/12.
//  Copyright (c) 2012 Tao Xie. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface NSDictionary (JSONCategories)
+(NSDictionary*)dictionaryWithContentsOfJSONURLString:(NSString*)urlAddress;
-(NSData*)toJSON;
@end
