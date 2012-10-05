//
//  NSDictionary+JSONCategories.m
//  Rizedu
//
//  Created by Tao Xie on 10/5/12.
//  Copyright (c) 2012 Tao Xie. All rights reserved.
//

#import "NSDictionary+JSONCategories.h"

@implementation NSDictionary (JSONCategories)
+(NSDictionary*)dictionaryWithContentsOfJSONURLString:(NSString*)urlAddress {
    NSData* data = [NSData dataWithContentsOfURL:[NSURL URLWithString: urlAddress] ];
    __autoreleasing NSError* error = nil;
    id result = [NSJSONSerialization JSONObjectWithData:data
                                                options:kNilOptions error:&error];
    if (error != nil) return nil;
    return result;
}

-(NSData*)toJSON
{
    NSError* error = nil;
    id result = [NSJSONSerialization dataWithJSONObject:self options:kNilOptions error:&error];
    if (error != nil) return nil;
    return result;    
}
@end
