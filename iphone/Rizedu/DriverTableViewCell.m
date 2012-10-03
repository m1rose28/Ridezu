//
//  HistoryTableViewCell.m
//  Flash2Pay
//
//  Created by Tao Xie on 5/13/12.
//  Copyright (c) 2012 Ridezu Inc. All rights reserved.
//

#import "DriverTableViewCell.h"

@implementation DriverTableViewCell
@synthesize imageView, nameLabel;

- (id)initWithStyle:(UITableViewCellStyle)style reuseIdentifier:(NSString *)reuseIdentifier
{
    self = [super initWithStyle:style reuseIdentifier:reuseIdentifier];
    if (self) {
        // Initialization code
        self.backgroundColor = [UIColor colorWithRed:255/255.f green:228/255.f blue:196/255.f alpha:250/255.f];
    }
    return self;
}

- (void)setSelected:(BOOL)selected animated:(BOOL)animated
{
    [super setSelected:selected animated:animated];

    // Configure the view for the selected state
}

@end
