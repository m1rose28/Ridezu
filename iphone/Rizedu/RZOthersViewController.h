//
//  RZOthersViewController.h
//  Rizedu
//
//  Created by Tao Xie on 11/4/12.
//  Copyright (c) 2012 Tao Xie. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface RZOthersViewController : UIViewController <UIWebViewDelegate>
- (id)initWithPath:(NSString*)path andTitle:(NSString*)title withRevealBlock:(RevealBlock)revealBlock;
@end
