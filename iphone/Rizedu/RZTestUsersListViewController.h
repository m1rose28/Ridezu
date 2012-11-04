//
//  RZMasterViewController.h
//  Rizedu
//
//  Created by Tao Xie on 9/22/12.
//  Copyright (c) 2012 Ridezu Inc. All rights reserved.
//

#import <UIKit/UIKit.h>
//typedef void (^RevealBlock)();

@class RZDetailViewController;

@interface RZMasterViewController : UITableViewController {
@private
	RevealBlock _revealBlock;
}

@property (strong, nonatomic) RZDetailViewController *detailViewController;
- (id)initWithTitle:(NSString *)title withRevealBlock:(RevealBlock)revealBlock;

@end
