//
//  HistoryTableViewCell.h
//  Flash2Pay
//
//  Created by Tao Xie on 5/13/12.
//  Copyright (c) 2012 Netspectrum Inc,. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface HistoryTableViewCell : UITableViewCell

@property (strong, nonatomic) IBOutlet UIImageView *imageView;
@property (strong, nonatomic) IBOutlet UILabel *nameLabel;
@property (strong, nonatomic) IBOutlet UITextView *descriptionTextView;
@property (strong, nonatomic) IBOutlet UILabel *priceLabel;

@end
