//
//  TopView.h
//  Rizedu
//
//  Created by Tao Xie on 11/4/12.
//  Copyright (c) 2012 Tao Xie. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface TopView : UIView
@property (nonatomic, strong) IBOutlet UILabel *costSavingAmountLabel;
@property (nonatomic, strong) IBOutlet UILabel *gasCarbonSavingLabel;
@property (nonatomic, strong) IBOutlet UIButton *homeOfficeSwitchButton;
@property (nonatomic, strong) IBOutlet UIView *routeContainerView;

- (void)customize;
@end
