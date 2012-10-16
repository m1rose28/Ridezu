//
//  RidezuEngine.h
//  MKNetworkDemo
//
//  Created by Tao Xie on 10/9/12.
//  Copyright (c) 2012 Trilleum Inc. All rights reserved.
//

#import "MKNetworkEngine.h"

@interface RidezuEngine : MKNetworkEngine
typedef void (^RidezuResponseBlock)(NSData *responseData);

@end

/*


 @interface YahooEngine : MKNetworkEngine
 
 typedef void (^CurrencyResponseBlock)(double rate);
 
 -(MKNetworkOperation*) currencyRateFor:(NSString*) sourceCurrency
 inCurrency:(NSString*) targetCurrency
 onCompletion:(CurrencyResponseBlock) completion
 onError:(MKNKErrorBlock) error;
 @end

*/